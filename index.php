<?php
require "php\db.php"; // Подключение к базе

$categories = [
    "smartphones",
    "computers",
    "peripherals",
    "gadgets_accessories",
    "televisions",
    "cameras",
    // "kitchen_appliances",
    // "home_appliances"
];
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gadget Zone</title>
    <link rel="icon" href="../photo/icon.jpg">
    <link rel="stylesheet" href="../css/home.css">
	 <link rel="stylesheet" href="../css/header__BurgerCategory-none.css">
	 <link rel="stylesheet" href="../css/footer.css">
	 <link rel="stylesheet" href="../css/global.css">
</head>
<body>
	<header>
		<a href="index.php">
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
			<a href="/adminpanel/admin.php">
		 		<div class="catalog-container">
			 		<img src="../photo/icon-avatar.png" alt="">
		 		</div>
			</a>
		  <a href="../html/shop.html">
			<div class="catalog-container">
				<img src="../photo/icon-basket.png" alt="">
			</div>
	  </a>
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

    <div class="main-container">
		<div class="menu1">
			<a href="../html/phone-catalog.html">
				 <div class="menu-item">
					  <img src="../photo/mobils.jpg" alt="smartphone">
					  <span>Смартфони та телефони</span>
				 </div>
			</a>
			<a href="../html/computer-catalog.html">
				 <div class="menu-item">
					  <img src="../photo/laptop.png" alt="laptop">
					  <span>Комп'ютери та ноутбуки</span>
				 </div>
			</a>
			<a href="../html/game-catalog.html">
				 <div class="menu-item">
					  <img src="../photo/game.png" alt="gaming">
					  <span>Ігрова зона</span>
				 </div>
			</a>
			<a href="../html/gadget-catalog.html">
				 <div class="menu-item">
					  <img src="../photo/1488.png" alt="gadget">
					  <span>Гаджети та аксесуари</span>
				 </div>
			</a>
			<a href="../html/tv-catalog.html">
				 <div class="menu-item">
					  <img src="../photo/tv.png" alt="tv">
					  <span>Телевізори та монітори</span>
				 </div>
			</a>
			<a href="../html/photo-catalog.html">
				 <div class="menu-item">
					  <img src="../photo/apapat.png" alt="foto">
					  <span>Фото та відео</span>
				 </div>
			</a>
			<a href="../html/kichen-catalog.html">
				 <div class="menu-item">
					  <img src="../photo/holodilnik.png" alt="foto">
					  <span>Техніка для кухні</span>
				 </div>
			</a>
			<a href="../html/home-catalog.html">
				 <div class="menu-item">
					  <img src="../photo/sosalka.png" alt="foto">
					  <span>техніка для дому</span>
				 </div>
			</a>
	  </div>
		  <div class="wrapper">
			<div class="slider">
			  <div class="slider__item">
				 <img src="../photo/banner1.jpg" alt="">
			  </div>
			  <div class="slider__item">
				 <img src="../photo/banner2.png" alt="">
			  </div>
			  <div class="slider__item">
				 <img src="../photo/banner3.jpg" alt="">
			  </div>
			  </div>
			</div>
		 </div>
    </div> 


    <div class="line"></div>


	 <div class="products-zona">
		<h2 class="actual">Товар тижня</h2>
		
			<?php
			echo '<div class="products-container">';

			foreach ($categories as $category) {
				$sql = "SELECT * FROM $category ORDER BY price DESC LIMIT 1";
				$result = $conn->query($sql);
			
				while ($row = $result->fetch_assoc()) {
					$product_url = "/php/tovar.php?category=" . urlencode($category) . "&id=" . urlencode($row['id']);


					$image_url = !empty($row['image_url']) ? $row['image_url'] : "/photo/logo.png"; // Путь к заглушке, если нет изображения
					$title = $row['manufacturer'] . " " . $row['model'];
					$price = number_format($row['price'], 0, '.', ' ') . " ₴";
			
					echo '
						<a href="' . $product_url . '" class="product-card">
							<div class="product-image">
								<img src="' . $image_url . '" alt="' . htmlspecialchars($title) . '">
							</div>
							<div class="product-info">
								<h3 class="product-title">' . htmlspecialchars($title) . '</h3>
								<p class="product-price">' . $price . '</p>
							</div>
						</a>';
				}
			}
			
			echo '</div>'; // Закрываем .products-container
			?>
  

    <div class="line"></div>
<!-- Товар тижня -->
<div class="products-zona">
	<h2 class="actual">Найкращі пропозиції</h2>

	<?php
			echo '<div class="products-container">';

			foreach ($categories as $category) {
				$sql = "SELECT * FROM $category ORDER BY id DESC LIMIT 3";
				$result = $conn->query($sql);
			
				while ($row = $result->fetch_assoc()) {
					$product_url = "/php/tovar.php?category=" . urlencode($category) . "&id=" . urlencode($row['id']);


					$image_url = !empty($row['image_url']) ? $row['image_url'] : "/photo/logo.png"; // Путь к заглушке, если нет изображения
					$title = $row['manufacturer'] . " " . $row['model'];
					$price = number_format($row['price'], 0, '.', ' ') . " ₴";
			
					echo '
						<a href="' . $product_url . '" class="product-card">
							<div class="product-image">
								<img src="' . $image_url . '" alt="' . htmlspecialchars($title) . '">
							</div>
							<div class="product-info">
								<h3 class="product-title">' . htmlspecialchars($title) . '</h3>
								<p class="product-price">' . $price . '</p>
							</div>
						</a>';
				}
			}
			
			echo '</div>'; 
	?>
	<div class="read-more">
	  <button type="button" class="btn" >Дивитися більше</button>
	  <button type="button" class="btn-minus" >Дивитися менше</button>
	</div>
	
</div>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>	
	<script src="../js/slick.min.js"></script>
	<script src="../js/script.js"></script>
	
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
</body>
</html>