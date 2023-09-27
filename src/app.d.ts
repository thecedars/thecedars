import 'unplugin-icons/types/svelte';

declare global {
	interface Window {
		grecaptcha: {
			execute: (s: string, x: { action: string }) => Promise<string>;
		};
	}

	interface Element {
		validity: { valid: boolean };
		reportValidity: () => void;
	}
}
