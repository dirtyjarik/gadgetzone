document.addEventListener("DOMContentLoaded", function () {
    const filters = document.querySelectorAll(".filter-option input");
    const productGrid = document.querySelector(".product-grid");


    
    function fetchProducts() {
        let params = new URLSearchParams();

        // Получаем текущую категорию из data-атрибута (например, data-category="smartphones")
        let category = document.querySelector(".filter-section").dataset.category;
        params.append("category", category);

        filters.forEach(filter => {
            if (filter.checked) {
                params.append(filter.name, filter.value);
            }
        });


        
        
        fetch(`/php/get_products.php?${params.toString()}`)
    .then(response => response.json()) // Преобразуем ответ в JSON
    .then(data => {
        console.log("Ответ от сервера:", data);

        if (!Array.isArray(data)) {
            throw new Error("Ошибка: сервер вернул не массив!");
        }

        productGrid.innerHTML = "";

        if (data.length === 0) {
            productGrid.innerHTML = "<p>Нет товаров, подходящих под выбранные фильтры.</p>";
            return;
        }

        data.forEach(product => {
            // Проверяем, есть ли название модели
             if (!product.model.trim()) return;

            const productCard = `
               
                <a href="../php/tovar.php?category=${encodeURIComponent(category)}&id=${product.id}" class="product-card">
                <div class="product-image">
                    <img src="../photo/${product.image_url}"  alt="${product.model}">
                </div>
                <div class="product-info">
                    <h3 class="product-title"> ${product.manufacturer} ${product.model} </h3>
                    <p class="product-price">${product.price} грн</p>
                </div>
            </a>
            `;
            productGrid.innerHTML += productCard;
        });
    })
    .catch(error => console.error("Ошибка:", error));
    }

    filters.forEach(filter => {
        filter.addEventListener("change", fetchProducts);
    });

    
    fetchProducts(); // Загружаем товары при старте
});
