import "./bootstrap";
import "preline";

const themeStorageKey = "theme";

const getStoredTheme = () => localStorage.getItem(themeStorageKey);
const getSystemTheme = () =>
	window.matchMedia("(prefers-color-scheme: dark)").matches
		? "dark"
		: "light";

const updateThemeIcons = (theme) => {
	const isDark = theme === "dark";
	document
		.querySelectorAll("[data-theme-icon='dark']")
		.forEach((icon) => icon.classList.toggle("hidden", isDark));
	document
		.querySelectorAll("[data-theme-icon='light']")
		.forEach((icon) => icon.classList.toggle("hidden", !isDark));
};

const applyTheme = (theme) => {
	document.documentElement.classList.toggle("dark", theme === "dark");
	updateThemeIcons(theme);
};

const initTheme = () => {
	const storedTheme = getStoredTheme();
	applyTheme(storedTheme ?? getSystemTheme());

	if (!storedTheme) {
		const media = window.matchMedia("(prefers-color-scheme: dark)");
		media.addEventListener("change", (event) => {
			if (!getStoredTheme()) {
				applyTheme(event.matches ? "dark" : "light");
			}
		});
	}
};

const initThemeToggles = () => {
	document.querySelectorAll("[data-theme-toggle]").forEach((button) => {
		// Prevent double initialization
		if (button.hasAttribute('data-theme-initialized')) {
			return;
		}
		button.setAttribute('data-theme-initialized', 'true');
		
		button.addEventListener("click", () => {
			const nextTheme = document.documentElement.classList.contains("dark")
				? "light"
				: "dark";
			localStorage.setItem(themeStorageKey, nextTheme);
			applyTheme(nextTheme);
		});
	});
};

document.addEventListener("DOMContentLoaded", () => {
	initTheme();
	initThemeToggles();
});

// Re-initialize theme toggles after Livewire navigation
document.addEventListener("livewire:navigated", () => {
	initTheme();
	initThemeToggles();
});
