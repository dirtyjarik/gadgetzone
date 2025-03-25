	  //бургер
	  document.addEventListener('DOMContentLoaded', function() {
		const burgerPhoto = document.querySelector('.burger-photo');
	  const burgerMenu = document.querySelector('.burger-menu');
	  burgerPhoto.addEventListener('click', function(i) {
	  burgerMenu.classList.toggle('active');
	});
	  document.addEventListener('click', function(i) {
		  if (!burgerMenu.contains(i.target) && !burgerPhoto.contains(i.target)) {
			  burgerMenu.classList.remove('active');
		  }
	});
  });

  document.addEventListener('DOMContentLoaded', function() {
  const sityBlock = document.querySelector('.sity');
  const sityMenu = document.querySelector('.sity-menu');
  const sityImage = document.querySelector('.sity img');
  let sitySpan = document.querySelector('.sity span');
  const cityOptions = document.querySelectorAll('.sity-menu div');
  // Відкриття меню
  sityBlock.addEventListener('click', function(e) {
		sityMenu.classList.toggle('active');//додаємо клас актив*
		sityImage.classList.toggle('rotate');
  });
  // Зміна міста при виборі
  cityOptions.forEach(city => {
		city.addEventListener('click', function(e) {
			 sitySpan.textContent = this.textContent;
			 sityMenu.classList.remove('active');
			 sityImage.classList.remove('rotate');
		});
  });
  // Закриття меню при кліку поза ним
  document.addEventListener('click', function(c) {
		if (!sityBlock.contains(c.target)) {
			 sityMenu.classList.remove('active');
			 sityImage.classList.remove('rotate');
		}
  });
  });


  //дивитися більше
  document.addEventListener('DOMContentLoaded', function() {
	const readMore = document.querySelector('.read-more');
	const readMoreBtn = readMore.querySelector('.btn');
	const productCards = document.querySelectorAll('.product-card');
	const visibleCards = 12;
	let visibleCardsNow = 0;
	// приховування карточек
	function catallog() {		 
		 productCards.forEach((card, i) => {
			  if (i < visibleCards) {
					card.style.display = 'block';
					visibleCardsNow++;
			  } else {
					card.style.display = 'none';
			  }
		 });
		 updatereadMoreBtn();
	}

	// следущая партия
	function showMore() {
		 const startIndex = visibleCardsNow;
		 const endIndex = Math.min(startIndex + visibleCards, productCards.length);
		 for (let i = startIndex; i < endIndex; i++) {
			  productCards[i].style.display = 'block';
			  visibleCardsNow++;
		 }
		 updatereadMoreBtn();
	}

	//оновлення стану кнопки дивитися більше
	function updatereadMoreBtn() {
		 if (visibleCardsNow >= productCards.length) {
			  readMore.style.display = 'none';
		 }
	}
	//запускаєм цю їбучу хуйню
	catallog();
	readMoreBtn.addEventListener('click', showMore);
});
//каталог
document.addEventListener('DOMContentLoaded', function() {
	const catalogContainer = document.querySelector('.catalog-tovar');
	const catalogMenu = document.querySelector('.catalog-menu');
	
	catalogContainer.addEventListener('click', function(e) {
		 catalogMenu.classList.toggle('active');
	});
	
	document.addEventListener('click', function(e) {
		 if (!catalogMenu.contains(e.target) && !catalogContainer.contains(e.target)) {
			  catalogMenu.classList.remove('active');
		 }
	});
});
//фильтр
document.addEventListener('DOMContentLoaded', function() {
	// Отримуємо всі заголовки фільтрів
	const filterHeaders = document.querySelectorAll('.filter-header');
	
	// Додаємо обробник подій для кожного заголовка фільтра
	filterHeaders.forEach(header => {
		 header.addEventListener('click', function(event) {
			  // Зупиняємо спливання події, щоб не закривати фільтр
			  event.stopPropagation();

			  // Знаходимо опції фільтра для поточного заголовка
			  const filterOptions = this.nextElementSibling;
			  
			  // Знаходимо зображення (іконку) для поточного заголовка
			  const filterImage = this.querySelector('img');
			  
			  // Перемикаємо клас active для опцій фільтра
			  filterOptions.classList.toggle('active');
			  
			  // Обертаємо іконку
			  filterImage.classList.toggle('rotate');
		 });
	});
	// Зупиняємо закриття фільтрів при кліку всередині блоку фільтрів
	const sidebar = document.querySelector('.sidebar');
	sidebar.addEventListener('click', function(event) {
		 event.stopPropagation();
	});
});