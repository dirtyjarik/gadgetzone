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
//каталог
document.addEventListener('DOMContentLoaded', function() {
	const catalogContainer = document.querySelector('.catalog-container');
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
//слайдер
$('.slider').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: false,
	fade: true,
	asNavFor: '.slider-nav'
 });
 $('.slider-nav').slick({
	slidesToShow: 3,
	slidesToScroll: 1,
	asNavFor: '.slider',
	dots: false,
	centerMode: true,
	focusOnSelect: true,

 });