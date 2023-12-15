export function toBase64(file: File): Promise<string> {
	return new Promise((resolve, reject) => {
		const reader = new FileReader();
		reader.readAsDataURL(file);
		reader.onload = () =>
			resolve(
				reader.result instanceof ArrayBuffer
					? arrayBufferToString(reader.result)
					: reader.result || ''
			);
		reader.onerror = reject;
	});
}

function arrayBufferToString(buffer: ArrayBuffer): Promise<string> {
	const blob = new Blob([buffer], { type: 'text/plain; charset=utf-8' });
	return blob.text();
}
