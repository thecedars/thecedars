declare global {
	namespace App {}
	interface EventTarget {
		value: string | undefined;
	}
}

export {};
