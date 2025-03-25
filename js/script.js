
document.addEventListener('DOMContentLoaded', function() {
	const zona = document.querySelectorAll('.products-zona');

	zona.forEach(function(section) {
		 const btn = section.querySelector('.btn');
		 const btnMinus = section.querySelector('.btn-minus');
		 const cards = section.querySelectorAll('.product-card');
		 btn.style.display = 'none';
		 btnMinus.style.display = 'none';
		 function cardToVisual() {
			  const screenWidth = window.innerWidth;
			  if (screenWidth > 1600) return 8;
			  if (screenWidth > 1554) return 7;
			  if (screenWidth > 1112) return 6;
			  if (screenWidth > 982) return 4;
			  if (screenWidth > 675) return 3;
			  return 2;
		 }

		 // функція для перевірки, чи мають відображатися кнопки
		 function shouldShowButtons() {
			  const visibleCount = cardToVisual();
			  // якщо у нас більше карток, ніж може поміститися в один ряд, нам знадобляться кнопки
			  return cards.length > visibleCount;
		 }

		 // функція оновлення видимості картки
		 function updateCardVisibility(showAll = false) {
			  const visibleCount = cardToVisual();
			  
			  cards.forEach((card, index) => {
					if (showAll || index < visibleCount) {
						 card.style.display = 'flex';
					} else {
						 card.style.display = 'none';
					}
			  });
			  if (shouldShowButtons()) {
					if (showAll) {
						 btn.style.display = 'none';
						 btnMinus.style.display = 'flex';
					} else {
						 btn.style.display = 'flex';
						 btnMinus.style.display = 'none';
					}
			  } else {
					// приховати обидві кнопки, якщо всі картки поміщаються в один ряд
					btn.style.display = 'none';
					btnMinus.style.display = 'none';
			  }
		 }
		 // початкове налаштування
		 updateCardVisibility();
		 // обробники натискання кнопки
		 btn.addEventListener('click', function() {
			  updateCardVisibility(true);
		 });
		 btnMinus.addEventListener('click', function() {
			  updateCardVisibility(false);
		 });
		 // изменение размера окна
		 window.addEventListener('resize', function() {
			  updateCardVisibility();
		 });
	});
});

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
$(document).ready(function(){
$('.slider').slick({
	arrows: false,
	dots: true,
	easing: 'ease',
	autoplay:true,
	autoplaySpeed:2000,
	adaptiveHight:true,
	

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
