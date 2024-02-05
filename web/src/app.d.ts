declare global {
	interface Window {
		grecaptcha: {
			execute: (s: string, x: { action: string }) => Promise<string>;
		};
	}
}

export {};
