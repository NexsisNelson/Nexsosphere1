const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]'
);

const switchTheme = (e) => {
    if(e.target.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
    } else {
        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem('theme', 'light');
    }
}

const currentTheme = localStorage.getItem('theme') ? localStorage.getItem
('theme') : null;

if(currentTheme) {
    document.documentElement.setAttribute('data-theme', currentTheme);

   if(currentTheme === 'dark') {
        toggleSwitch.checked = true;
    }
}

toggleSwitch.addEventListener('change', switchTheme)