document.addEventListener('DOMContentLoaded', function() {
	const cityButtons = document.querySelectorAll('.sity-shop');
	const mapLists = document.querySelectorAll('.map-list');
	cityButtons.forEach((button, index) => {	// Додаємо обробник подій для кожної кнопки міста
		 button.addEventListener('click', function() {
			  cityButtons.forEach(btn => {
					btn.classList.remove('active');
			  });
			  this.classList.add('active');
			  mapLists.forEach(mapList => {
					mapList.classList.remove('actual');
			  });
			  if (mapLists[index]) {
					mapLists[index].classList.add('actual');// Додаємо клас 'actual' до блоку карти, що відповідає обраному місту
			  }
		 });
	});
});
document.addEventListener('DOMContentLoaded', function() {
	const cityButtons = document.querySelectorAll('.sity-shop');
	const mapLists = document.querySelectorAll('.map-list');
	cityButtons.forEach((button, index) => {	// Додаємо обробник подій для кожної кнопки міста
		 button.addEventListener('click', function() {
			  
			  cityButtons.forEach(btn => {
					btn.classList.remove('active');// Видаляємо active з усіх кнопок міст
			  });
			  this.classList.add('active');
			  mapLists.forEach(mapList => {			  // Видаляємо клас 'actual' з усіх блоків карт і адрес
					mapList.classList.remove('actual');
			  });
			  if (mapLists[index]) {
					mapLists[index].classList.add('actual');
			  }
		 });
	});
	const addressSectors = document.querySelectorAll('.list-sector');
	const maps = document.querySelectorAll('.map');
	addressSectors.forEach((sector, index) => {	// Додаємо обробник подій для кожного сектору адреси
		 sector.addEventListener('click', function() {
			  addressSectors.forEach(sec => {
					sec.classList.remove('list-sector-active');			  // Видаляємо клас 'list-sector-active' з усіх секторів адрес
			  });
			  this.classList.add('list-sector-active');
			  maps.forEach(map => {			  // Видаляємо клас 'now' з усіх карт
					map.classList.remove('now');
			  });	
			  if (maps[index]) {
					maps[index].classList.add('now');			  // Додаємо клас 'now' до карти, що відповідає обраній адресі
			  }
		 });
	});
});