import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';

Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();

const initFlatpickr = async () => {
    const datepicker = document.querySelector('.datepicker');
    if (!datepicker) return;

    await import('flatpickr/dist/flatpickr.min.css');
    const { default: flatpickr } = await import('flatpickr');

    flatpickr('.datepicker', {
        mode: 'range',
        static: true,
        monthSelectorType: 'static',
        dateFormat: 'M j',
        defaultDate: [new Date().setDate(new Date().getDate() - 6), new Date()],
        prevArrow:
            '<svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M15.25 6L9 12.25L15.25 18.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        nextArrow:
            '<svg class="stroke-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.75 19L15 12.75L8.75 6.5" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>',
        onReady: (selectedDates, dateStr, instance) => {
            instance.element.value = dateStr.replace('to', '-');
            const customClass = instance.element.getAttribute('data-class');
            if (customClass) {
                instance.calendarContainer.classList.add(customClass);
            }
        },
        onChange: (selectedDates, dateStr, instance) => {
            instance.element.value = dateStr.replace('to', '-');
        },
    });
};

const initDropzone = async () => {
    const dropzoneArea = document.querySelector('#demo-upload');
    if (!dropzoneArea) return;

    await import('dropzone/dist/dropzone.css');
    const { default: Dropzone } = await import('dropzone');

    new Dropzone('#demo-upload', { url: '/file/post' });
};

const initCharts = async () => {
    const needsCharts =
        document.querySelector('#chartOne') ||
        document.querySelector('#chartTwo') ||
        document.querySelector('#chartThree');

    if (!needsCharts) return;

    const [{ default: chart01 }, { default: chart02 }, { default: chart03 }] =
        await Promise.all([
            import('../template/js/components/charts/chart-01'),
            import('../template/js/components/charts/chart-02'),
            import('../template/js/components/charts/chart-03'),
        ]);

    chart01();
    chart02();
    chart03();
};

const initMap = async () => {
    const mapTarget = document.querySelector('#mapOne');
    if (!mapTarget) return;

    await import('jsvectormap/dist/jsvectormap.min.css');
    const { default: map01 } = await import('../template/js/components/map-01');
    map01();
};

const initCalendar = async () => {
    const calendarTarget = document.querySelector('#calendar');
    if (!calendarTarget) return;

    const { default: initCalendarModule } = await import(
        '../template/js/components/calendar-init'
    );
    initCalendarModule();
};

const initImageResize = async () => {
    const pane = document.querySelector('#pane');
    if (!pane) return;

    await import('../template/js/components/image-resize');
};

const initCopy = () => {
    const copyInput = document.getElementById('copy-input');
    if (!copyInput) return;

    const copyButton = document.getElementById('copy-button');
    const copyText = document.getElementById('copy-text');
    const websiteInput = document.getElementById('website-input');

    if (!copyButton || !copyText || !websiteInput) return;

    copyButton.addEventListener('click', () => {
        navigator.clipboard.writeText(websiteInput.value).then(() => {
            copyText.textContent = 'Copied';
            setTimeout(() => {
                copyText.textContent = 'Copy';
            }, 2000);
        });
    });
};

const initSearchShortcut = () => {
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');

    if (!searchInput || !searchButton) return;

    const focusSearchInput = () => {
        searchInput.focus();
    };

    searchButton.addEventListener('click', focusSearchInput);

    document.addEventListener('keydown', (event) => {
        if ((event.metaKey || event.ctrlKey) && event.key === 'k') {
            event.preventDefault();
            focusSearchInput();
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === '/' && document.activeElement !== searchInput) {
            event.preventDefault();
            focusSearchInput();
        }
    });
};

document.addEventListener('DOMContentLoaded', () => {
    const year = document.getElementById('year');
    if (year) {
        year.textContent = new Date().getFullYear();
    }

    initCopy();
    initSearchShortcut();
    initFlatpickr();
    initDropzone();
    initCharts();
    initMap();
    initCalendar();
    initImageResize();
});
