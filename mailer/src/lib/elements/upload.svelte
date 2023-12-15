<script lang="ts">
	import { onMount } from 'svelte';

	export let name: string;
	export let label = '';
	export let id = name;
	let filename = '';
	let fileUploadElement: HTMLInputElement;
	let className = '';

	function drop(event: DragEvent) {
		const data = event.dataTransfer;
		const files = data ? data.files : null;

		if (files && fileUploadElement) {
			const container = new DataTransfer();
			container.items.add(files[0]); // Only add the first file.
			fileUploadElement.files = container.files;
			handleFileSelection();
		}
	}

	function handleFileSelection() {
		if (fileUploadElement && fileUploadElement.files) {
			const file = fileUploadElement.files[0];
			if (file) {
				filename = file.name;
			}
		}
	}

	onMount(() => {
		const resetFilename = () => {
			filename = '';
		};

		if (fileUploadElement) fileUploadElement.form?.addEventListener('reset', resetFilename);

		return () => {
			if (fileUploadElement) fileUploadElement.form?.removeEventListener('reset', resetFilename);
		};
	});

	export { className as class };
</script>

<div class={className}>
	{#if label}
		<label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">
			{label}
		</label>
	{/if}
	<div
		on:dragover|preventDefault={() => null}
		on:dragenter|preventDefault={() => null}
		on:drop|preventDefault={drop}
		role="application"
		class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10"
	>
		<div class="text-center">
			<svg class="mx-auto h-12 w-12 text-gray-300" viewBox="0 0 24 24" aria-hidden="true">
				<path
					fill-rule="evenodd"
					d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z"
					clip-rule="evenodd"
				/>
			</svg>
			<div class="mt-4 flex text-sm leading-6 text-gray-600">
				<label
					for={id}
					class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500"
				>
					<span>Upload a file</span>
					<input
						{id}
						{name}
						type="file"
						class="sr-only"
						bind:this={fileUploadElement}
						on:change={handleFileSelection}
					/>
				</label>
				<p class="pl-1">or drag and drop</p>
			</div>
			{#if filename}<p class="text-xs leading-5 text-gray-600">{filename}</p>{/if}
		</div>
	</div>
</div>
