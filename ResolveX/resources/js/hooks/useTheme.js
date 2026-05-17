import { useState, useEffect } from 'react';

export const useTheme = () => {
    const [isDarkMode, setIsDarkMode] = useState(() => {
        // Check localStorage first
        if (localStorage.theme === 'light') {
            return false;
        } else if (localStorage.theme === 'dark') {
            return true;
        }
        // Fall back to system preference
        return window.matchMedia('(prefers-color-scheme: dark)').matches;
    });

    useEffect(() => {
        const html = document.documentElement;
        if (isDarkMode) {
            html.classList.add('dark');
            localStorage.theme = 'dark';
        } else {
            html.classList.remove('dark');
            localStorage.theme = 'light';
        }
    }, [isDarkMode]);

    const toggleTheme = () => setIsDarkMode(!isDarkMode);

    return { isDarkMode, toggleTheme };
};
