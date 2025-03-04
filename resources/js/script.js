document.addEventListener('DOMContentLoaded', function () {
  const button = document.getElementById('navbar-toggle');
  const menu = document.getElementById('navbar-dropdown');

  const dropdownButton = document.getElementById('dropdownNavbarLink');
  const dropdownMenu = document.getElementById('dropdownNavbar');

  const doubleDropdownButton = document.getElementById('doubleDropdownButton');
  const doubleDropdown = document.getElementById('doubleDropdown');

  dropdownButton.addEventListener('click', () => {
    dropdownMenu.classList.toggle('hidden');
  });

  doubleDropdownButton.addEventListener('click', () => {
    doubleDropdown.classList.toggle('hidden');
  });

  button.addEventListener('click', function () {
    menu.classList.toggle('hidden');
  });
});