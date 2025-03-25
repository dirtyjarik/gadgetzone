<?php
// Подключение к базе данных
$host = 'MySQL-8.2';
$dbname = 'gadgetzone';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

$category = isset($_GET['category']) ? $_GET['category'] : '';
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Проверка на валидность параметров
if (empty($category) || $product_id <= 0) {
    die("Необходимо указать категорию и ID товара");
}

// Массив для хранения переводов полей
$field_translations = [
    // Общие поля для всех категорий
    'manufacturer' => 'Виробник',
    'model' => 'Модель',
    'price' => 'Ціна',
    'image_url' => 'Зображення',
    'additional_features' => 'Додаткові особливості',
    
    // Smartphones
    'operating_system' => 'Операційна система',
    'screen_size' => 'Розмір екрану',
    'screen_resolution' => 'Роздільна здатність екрану',
    'processor' => 'Процесор',
    'ram' => 'Оперативна пам\'ять',
    'storage' => 'Вбудована пам\'ять',
    'main_camera' => 'Основна камера',
    'front_camera' => 'Фронтальна камера',
    'battery_capacity' => 'Ємність акумулятора',
    'charging_type' => 'Тип зарядки',
    'support_5g' => 'Підтримка 5G',
    'sim_slots' => 'Кількість SIM-карт',
    'display_type' => 'Тип дисплею',
    
    // Computers
    'device_type' => 'Тип пристрою',
    'processor' => 'Процесор',
    'ram_capacity' => 'Об\'єм оперативної пам\'яті',
    'storage' => 'Об\'єм накопичувача',
    'gpu' => 'Відеокарта',
    'screen_resolution' => 'Роздільна здатність екрану',
    'display_type' => 'Тип дисплею',
    'refresh_rate' => 'Частота оновлення',
    'ports' => 'Порти',
    'wireless_interfaces' => 'Бездротові інтерфейси',
    'battery_capacity' => 'Ємність акумулятора',
    'dimensions_weight' => 'Розміри та вага',
    
    // Peripherals
    'device_type' => 'Тип пристрою',
    'supported_platforms' => 'Підтримувані платформи',
    'resolution_fps' => 'Роздільна здатність/FPS',
    'memory' => 'Пам\'ять',
    'media_type' => 'Тип носія',
    'ports' => 'Порти',
    'vr_support' => 'Підтримка VR',
    
    // Cameras
    'camera_type' => 'Тип камери',
    'sensor' => 'Сенсор',
    'photo_resolution' => 'Роздільна здатність фото',
    'video_recording' => 'Запис відео',
    'lens_type' => 'Тип об\'єктива',
    'focal_length' => 'Фокусна відстань',
    'stabilization' => 'Стабілізація',
    'storage_media' => 'Носій інформації',
    'ports' => 'Порти',
    'wireless_features' => 'Бездротові функції',
    'battery_capacity' => 'Ємність акумулятора',
    
    // Home appliances
    'vacuum_type' => 'Тип пилососа',
    'suction_power' => 'Потужність всмоктування',
    'filtration_type' => 'Тип фільтрації',
    'dustbin_capacity' => 'Об\'єм контейнера для пилу',
    'power_source' => 'Джерело живлення',
    'battery_life' => 'Час роботи від акумулятора',
    'noise_level' => 'Рівень шуму',
    'attachments' => 'Насадки',
    
    // Kitchen appliances
    'fridge_type' => 'Тип холодильника',
    'total_capacity' => 'Загальний об\'єм',
    'fridge_capacity' => 'Об\'єм холодильної камери',
    'freezer_capacity' => 'Об\'єм морозильної камери',
    'energy_consumption' => 'Енергоспоживання',
    'control_type' => 'Тип управління',
    'cooling_system' => 'Система охолодження',
    'shelves_drawers' => 'Полиці/ящики',
    'noise_level' => 'Рівень шуму',
    
    // Televisions
    'screen_size' => 'Розмір екрану',
    'screen_resolution' => 'Роздільна здатність',
    'display_type' => 'Тип дисплею',
    'refresh_rate' => 'Частота оновлення',
    'hdr_support' => 'Підтримка HDR',
    'operating_system' => 'Операційна система',
    'ports' => 'Порти',
    'voice_control' => 'Голосове керування',
    'sound' => 'Звук',
    'power_consumption' => 'Енергоспоживання',
    
    // Gadgets_accessories
    'compatible_with' => 'Сумісність',
    'connection_type' => 'Тип підключення',
    'battery_life' => 'Час роботи'
];

// Получение данных о товаре из базы данных
try {
    $query = "SELECT * FROM {$category} WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        die("Товар не найден");
    }
} catch (PDOException $e) {
    die("Ошибка при получении данных товара: " . $e->getMessage());
}

// Получение категоризированных характеристик
function categorizeCharacteristics($product) {
    $categories = [];
    
    // Определение категорий характеристик в зависимости от типа товара
    if (array_key_exists('screen_size', $product) || array_key_exists('display_type', $product)) {
        $categories['Екран'] = ['screen_size', 'screen_resolution', 'display_type', 'refresh_rate'];
    }
    
    if (array_key_exists('processor', $product)) {
        $categories['Процесор/Відеоприскорювач'] = ['processor', 'gpu'];
    }
    
    if (array_key_exists('ram', $product) || array_key_exists('storage', $product)) {
        $categories['Пам\'ять'] = ['ram', 'storage'];
    }
    
    if (array_key_exists('main_camera', $product) || array_key_exists('front_camera', $product)) {
        $categories['Камера'] = ['main_camera', 'front_camera', 'photo_resolution', 'video_recording'];
    }
    
    if (array_key_exists('battery_capacity', $product)) {
        $categories['Акумулятор'] = ['battery_capacity', 'battery_life', 'charging_type'];
    }
    
    if (array_key_exists('fridge_capacity', $product) || array_key_exists('freezer_capacity', $product)) {
        $categories['Об\'єм'] = ['total_capacity', 'fridge_capacity', 'freezer_capacity', 'dustbin_capacity'];
    }
    
    if (array_key_exists('operating_system', $product) || array_key_exists('supported_platforms', $product)) {
        $categories['Програмне забезпечення'] = ['operating_system', 'supported_platforms'];
    }
    
    if (array_key_exists('ports', $product) || array_key_exists('wireless_interfaces', $product)) {
        $categories['Підключення'] = ['ports', 'wireless_interfaces', 'wireless_features'];
    }
    
    // Если некоторые поля не попали ни в одну категорию, добавляем их в "Інші характеристики"
    $other_fields = [];
    foreach ($product as $key => $value) {
        if ($key != 'id' && $key != 'image_url' && $key != 'manufacturer' && $key != 'model' && $key != 'price' && $key != 'additional_features') {
            $found = false;
            foreach ($categories as $category_fields) {
                if (in_array($key, $category_fields)) {
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $other_fields[] = $key;
            }
        }
    }
    
    if (!empty($other_fields)) {
        $categories['Інші характеристики'] = $other_fields;
    }
    
    return $categories;
}

// Генерация HTML блока с характеристиками
function generateCharacteristicsHTML($product, $field_translations, $categorized_characteristics) {
    $html = '';
    
    foreach ($categorized_characteristics as $category_name => $fields) {
        $html .= '<h3 class="name-category">' . $category_name . '</h3>';
        
        foreach ($fields as $field) {
            if (isset($product[$field]) && !empty($product[$field]) && $field != 'id' && $field != 'image_url') {
                $field_name = isset($field_translations[$field]) ? $field_translations[$field] : $field;
                $value = $product[$field];
                
                // Форматирование значений для отображения
                if ($field == 'price') {
                    $value = number_format($value, 2, '.', ' ') . ' грн';
                } elseif ($field == 'ram' || $field == 'storage') {
                    $value .= ' ГБ';
                } elseif ($field == 'screen_size') {
                    $value .= '"';
                } elseif ($field == 'battery_capacity') {
                    $value .= ' мАг';
                }
                
                $html .= '<div class="characteristics-tovar">
                    <span class="characteristic">' . $field_name . ':</span>
                    <span class="characteristic-value">' . $value . '</span>
                </div>';
            }
        }
    }
    
    return $html;
}

// Получение изображений товара
function getProductImages($product_id, $category, $pdo) {
    // В реальном проекте здесь будет логика получения всех изображений товара
    // Для примера возвращаем фиктивные изображения
    return [
        $product_id . '_1.jpg',
        $product_id . '_2.jpg',
        $product_id . '_3.jpg',
        $product_id . '_4.jpg'
    ];
}

// Определение категорий характеристик
$categorized_characteristics = categorizeCharacteristics($product);

// Получение изображений товара
$product_images = getProductImages($product_id, $category, $pdo);

// Преобразование типа товара в украинское название категории
$category_translations = [
    'smartphones' => 'Смартфони',
    'computers' => 'Комп\'ютери та ноутбуки',
    'peripherals' => 'Периферійні пристрої',
    'cameras' => 'Фото та відео',
    'home_appliances' => 'Техніка для дому',
    'kitchen_appliances' => 'Техніка для кухні',
    'televisions' => 'Телевізори',
    'gadgets_accessories' => 'Гаджети та аксесуари'
];
$category_name = isset($category_translations[$category]) ? $category_translations[$category] : $category;

// Начало HTML шаблона (header уже есть в вашем шаблоне)
// Включаем только часть main с данными о товаре

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gadget Zone</title>
    <link rel="icon" href="../photo/icon.jpg">
    <link rel="stylesheet" href="../css/style-tovar.css">
	 <link rel="stylesheet" href="../css/header__BurgerCategory-True.css">
	 <link rel="stylesheet" href="../css/footer.css">
	 <link rel="stylesheet" href="../css/global.css">
</head>
<body>
	<header>
		<a href="/index.php">
			<div class="logo">
				 <img src="../photo/logo.jpg" alt="logo">
			</div>
		</a>

		<div class="sity">
		  <span>Київ</span>
		  <img src="../photo/more.png" alt="more">
		  <div class="sity-menu">
			 <div class="sity-name">Суми</div>
			 <div class="sity-name">Київ</div>
			 <div class="sity-name">Харків</div>
			 <div class="sity-name">Житомир</div>
			 <div class="sity-name">Одеса</div>
			 <div class="sity-name">Львів</div>
			 <div class="sity-name">Умань</div>
		  </div>
		</div>
		<div class="search-container">
			 <input type="text" placeholder="Що саме вам потрібно?">
		</div>

		<div class="con">
		 <div class="catalog-container">
			<!-- <img src="../photo/catalog.png" class="catalog-img" alt="catalog"> -->
			<span>Каталог товарів</span>
		 	<div class="catalog-menu">
				<div class="catalog-content">
				<a href="../html/phone-catalog.html">
					<div class="catalog-item">
						 <img src="../photo/mobils.jpg" alt="smartphone">
						 <span>Смартфони та телефони</span>
					</div>
				</a>
				<a href="../html/computer-catalog.html">
					<div class="catalog-item">
						 <img src="../photo/laptop.png" alt="laptop">
						 <span>Комп'ютери та ноутбуки</span>
					</div>
				</a>
				<a href="../html/game-catalog.html">
					<div class="catalog-item">
						 <img src="../photo/game.png" alt="gaming">
						 <span>Ігрова зона</span>
					</div>
				</a>
				<a href="../html/gadget-catalog.html">
					<div class="catalog-item">
						 <img src="../photo/1488.png" alt="gadget">
						 <span>Гаджети та аксесуари</span>
					</div>
				</a>
				<a href="../html/tv-catalog.html">
					<div class="catalog-item">
						 <img src="../photo/tv.png" alt="tv">
						 <span>Телевізори та монітори</span>
					</div>
				</a>
				<a href="../html/photo-catalog.html">
					<div class="catalog-item">
						 <img src="<?php echo $product['image_url'] ; ?>" alt="foto">
						 <span>Фото та відео</span>
					</div>
				</a>
				<a href="../html/kichen-catalog.html">
					<div class="catalog-item">
						 <img src="../photo/holodilnik.png" alt="foto">
						 <span>Техніка для кухні</span>
					</div>
				</a>
				<a href="../html/home-catalog.html">
					<div class="catalog-item">
						 <img src="../photo/sosalka.png" alt="foto">
						 <span>техніка для дому</span>
					</div>
				</a>
			</div>
			</div>
		 </div>

		 <div class="burger-container">
			 <img src="../photo/burger-menu.png" class="burger-photo" alt="burger">
			 <div class="burger-menu">
				  <div class="burger-content">
						<div class="accaunt">
							 <a href="" class="kabinet">Особистий кабінет</a>
						</div>
						<div class="fav-list">
							 <a href="../html/wish-list.html" class="spysok-bajan">Список бажань</a>
						</div>
						<div class="pro-nas">
							 <a href="../html/shop.html" class="my">Наші магазини</a>
						</div>
				  </div>
			 </div>
		</div>
	</div>
  </header>
  <div class="main">
	<div class="slider-tovar">
	<div class="wrapper">
		<div class="slider">
		  <div class="slider__item">
			 <img src="<?php echo $product['image_url'] ; ?>" alt="">
		  </div>
		  <div class="slider__item">
			 <img src="<?php echo $product['image_url'] ; ?>" alt="">
		  </div>
		  <div class="slider__item">
			 <img src="<?php echo $product['image_url'] ; ?>" alt="">
		  </div>
		  <div class="slider__item">
			<img src="<?php echo $product['image_url'] ; ?>" alt="">
		 </div>
		 <div class="slider__item">
			<img src="<?php echo $product['image_url'] ; ?>" alt="">
		 </div>
		 <div class="slider__item">
			<img src="<?php echo $product['image_url'] ; ?>" alt="">
		 </div>
		 <div class="slider__item">
			<img src="<?php echo $product['image_url'] ; ?>" alt="">
		 </div>
		  </div>
		  <div class="slider-nav">
			<div class="slider-nav__item">
				<img src="<?php echo $product['image_url'] ; ?>" alt="">
			 </div>
			 <div class="slider-nav__item">
				<img src="<?php echo $product['image_url'] ; ?>" alt="">
			 </div>
			 <div class="slider-nav__item">
				<img src="<?php echo $product['image_url'] ; ?>" alt="">
			 </div>
			 <div class="slider-nav__item">
				<img src="<?php echo $product['image_url'] ; ?>" alt="">
			 </div>
			 <div class="slider-nav__item">
				<img src="<?php echo $product['image_url'] ; ?>" alt="">
			 </div>
			 <div class="slider-nav__item">
				<img src="<?php echo $product['image_url'] ; ?>" alt="">
			 </div>
			 <div class="slider-nav__item">
				<img src="<?php echo $product['image_url'] ; ?>" alt="">
			 </div>
		  </div>
		</div>
</div>
<div class="info-tovar">
            <h2 class="name-tovar"><?php echo $product['manufacturer'] . ' ' . $product['model']; ?></h2>
            
            <?php 
            // Вывод категоризированных характеристик
            echo generateCharacteristicsHTML($product, $field_translations, $categorized_characteristics);
            
            // Вывод цены
            if (isset($product['price'])) {
                echo '<div class="price-section">
                    <span class="price-label">Ціна:</span>
                    <span class="price-value">' . number_format($product['price'], 2, '.', ' ') . ' грн</span>
                </div>';
            }
            ?>
            
           
        </div>
</div>

  </body>
  <footer>
	<div class="footer-content">
	  <div class="footer-columns">
		 <div class="logo-container">
			  <img src="../photo/logo.png" alt="Logo">
	  </div>
			  <div class="footer-column">
					<h3>Про наш магазин</h3>
					<p>На даному інтернет-каталозі ви зможете найти все що вам може бути потрібно. Всі наші товари ви зможете придбати в наших мазагих. 
					  Адреса наших магазинів: 
					  <b>м. Суми, ТРЦ "Мануфактура", вул. Харківська, 2/2 <br/>м. Суми,ТРЦ "Київ", вул. Нижньовоскресенська, 1 
						  <br/>м. Дніпро ,вул. Героїв Небесної Сотні, 2а
						  <br/>м. Київ,вул. Київський Шлях, 2/6	</b></p>
			  </div>
			  <div class="footer-column">
				  <h3>Наші контакти</h3>
				  <p>Маєте питання щодо товарів чи доставки? Потрібна консультація? Наша служба підтримки працює 24/7. Зв'яжіться з нами зручним для вас способом:</p>
				  <p><b>Email:<a href="#"> support@gadgetzone.ua</a></b></p>
				  <p><strong>Телефон: <a href="">0 800 300 300</a></strong></p>
				  <p><b>Telegram: <a href="">@GadgetZone_Support</a></b></p>
			 </div>
			 <div class="footer-column">
			  <h3>Наші соціальні мережі</h3>
			  <p>Приєднуйтесь до нас у соціальних мережах, щоб першими дізнаватися про новинки, акції та спеціальні пропозиції.</p>
			  <div class="social-links">
					<p><b>Instagram: </bи><a href="#">@gadget_zone_ua</a></p>
					<p><b>Facebook: </b><a href="#">GadgetZone Ukraine</a></p>
					<p><b>Telegram-канал: </b><a href="#">@gadgetzone_news</a></p>
					<p><b>YouTube: </b><a href="#">GadgetZone Channel</a></p>
					<p><b>TikTok: </b><a href="#">@gadgetzone.ua</a></p>
			  </div>
		 </div>

		 
		 </div>
	</div>
	<div class="copyright">
		 <small>Copyright &copy; 2025 Мудрий Ярослав 411-і</small>
	</div>

  </footer>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="../js/slick.min.js"></script>
  <script src="../js/script-tovar.js"></script>
  </html>