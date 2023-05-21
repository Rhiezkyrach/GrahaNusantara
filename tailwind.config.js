module.exports = {
    content: ["./resources/**/*.blade.php"],
    theme: {
        fontFamily: {
            'sans': ["Roboto", "sans-serif"],
        },
        extend: {
            fontSize: {
                'xxs': ["11px", "13px"],
                'xxxs': ["9px", "11px"],
            },
        },
    },
    darkMode: 'class',
    plugins: [
        require('flowbite/plugin')
    ],
};
