<script>
	import { MENU_ITEM } from '$lib/context/symbols.js';
	import { getContext, setContext } from 'svelte';

	/**
	 * @type {string}
	 */
	export let href;
	let hover = false;
	let opened = false;

	// When there's no context, we're at the top level.
	const hasContext = getContext(MENU_ITEM);
	setContext(MENU_ITEM, { context: true });

	const desktopClasses = !hasContext
		? 'px-2 lg:py-6 lg:px-4'
		: 'transition-colors duration-500 no-underline p-2 lg:pr-8 block color-inherit bg-white hover:bg-washed-green w-full';

	/**
	 * @param {MouseEvent} event
	 * @listens MouseEvent
	 */
	function toggleOpen(event) {
		if (!opened && $$slots.children) {
			event.preventDefault();
		}

		opened = !opened;
	}

	function hoverOn() {
		hover = true;
	}

	function hoverOff() {
		hover = false;
	}
</script>

<div
	class="relative z-1"
	tabindex="0"
	role="menuitem"
	on:mouseenter={hoverOn}
	on:mouseleave={hoverOff}
>
	<div class="flex items-center">
		<a class="lg:block hidden no-underline {desktopClasses} text-inherit" {href}>
			<span class="block"><slot /></span>
		</a>

		<a
			on:click={toggleOpen}
			class="lg:hidden block no-underline px-2 lg:py-6 lg:px-4 text-inherit"
			{href}
		>
			<span class="block"><slot /></span>
		</a>
	</div>

	{#if opened && $$slots.children}
		<div class="block lg:hidden">
			<slot name="children" />
		</div>
	{/if}

	{#if hover && $$slots.children}
		<div class="hidden lg:block lg:absolute z-1 lg:-mt-4">
			<div class="bg-white lg:shadow-lg">
				<slot name="children" />
			</div>
		</div>
	{/if}
</div>
