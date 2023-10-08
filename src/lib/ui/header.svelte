<script>
	import Hamburger from '~icons/mdi/menu';

	import AnnualMeetingBanner from './annual-meeting-banner.svelte';
	import HeaderNav from './header-nav.svelte';
	import Logo from './logo.svelte';

	let menuOpened = false;

	function toggleMenu() {
		menuOpened = !menuOpened;
	}
</script>

<header class="w-full max-w-5xl lg:py-4 mx-auto">
	<div class="lg:hidden bg-black text-white pl-2 pt-2 shadow-2xl">
		<div tabindex="0" role="button" on:click={toggleMenu} on:keypress={toggleMenu}>
			<Hamburger class="w-[1.75em] h-[1.75em] block cursor-pointer pb-2" />
		</div>

		{#if menuOpened}
			<div>
				<HeaderNav />
			</div>
		{/if}
	</div>

	<div class="hidden lg:block">
		<div class="flex items-center justify-between w-full">
			<div>
				<a href="/">
					<Logo class="max-w-[8rem] h-[64px] block" />
				</a>
			</div>

			<div class="relative z-2">
				<div>
					<div class="flex items-center justify-between whitespace-nowrap">
						<HeaderNav />
					</div>
				</div>
			</div>
		</div>
	</div>
</header>

<AnnualMeetingBanner />
