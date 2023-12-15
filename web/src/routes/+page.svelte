<script lang="ts">
	import Button from '$lib/ui/button.svelte';
	import Icon from '@iconify/svelte';
	import { onMount } from 'svelte';
	import { fly } from 'svelte/transition';

	let ready = false;

	onMount(() => {
		ready = true;
	});
</script>

<section>
	<div class="wp-block-the-cedars-hero-image">
		<div class="flex items-center my-16">
			<div class="lg:flex lg:items-center">
				<div class="lg:w-3/5 pr4-l mb-8 lg:mb-0">
					<div class="uppercase tracking-widest">
						The Cedars
						<span role="img" aria-label="Picture of a tree.">🌲</span>
					</div>
					<div class="text-5xl lg:text-7xl font-bold leading-normal mb-4">a piece of paradise</div>
					<div class="post-content text-gray-600">
						<div>
							<p>
								<strong>
									The Cedars is between Pflumm Road and Lackman Drive in the city of Lenexa, KS. The
									main entrance is located at 87th Street and Acuff Lane. There are 197 homes in the
									Cedars.
								</strong>
							</p>

							<div class="wp-block-the-cedars-button inline-block mr-4">
								<Button href="/resources/By-Laws-Amended-and-Adopted-March-2017.pdf">
									By-Laws
								</Button>
							</div>

							<div class="wp-block-the-cedars-button inline-block">
								<Button href="/resources/CedarsCovs.pdf" inverted>Covenants</Button>
							</div>
						</div>
					</div>
				</div>
				{#if ready}
					<div
						in:fly={{ x: 200 }}
						class="lg:w-2/5 overflow-hidden rounded-2xl shadow h-64 lg:h-fit"
					>
						<img src="/images/the-cedars.jpg" class="object-cover w-full h-full block" alt="" />
					</div>
				{:else}
					<div class="opacity-0 lg:w-2/5 overflow-hidden rounded-2xl shadow h-64 lg:h-fit">
						<img src="/images/the-cedars.jpg" class="object-cover w-full h-full block" alt="" />
					</div>
				{/if}
			</div>
		</div>
	</div>

	<div class="rounded-2xl bg-dark-green p-8 overflow-hidden text-gray-400 my-32">
		<div class="lg:flex lg:items-center -ml-4 -mr-4 -mt-3 -mb-4">
			<div class="lg:w-1/3 p-4">
				<div>
					<div class="w-50 mx-auto max-w-[4rem] mb-8">
						<div class="rounded-full bg-gray-100 aspect-square leading-normal">
							<a href="/resources/budget-2024.pdf" class="flex items-center justify-center h-full">
								<span class="block text-green">
									<Icon icon="mdi:cash" width="2em" height="2em" />
								</span>
							</a>
						</div>
					</div>
					<div class="text-center">
						<a href="/resources/budget-2024.pdf" class="no-underline">
							<div class="font-bold text-xl text-white">Budget</div>
							<div class="text-base text-gray-400">2024</div>
						</a>
					</div>
				</div>
			</div>

			<div class="lg:w-1/3 p-4">
				<div>
					<div class="w-50 mx-auto max-w-[4rem] mb-8">
						<div class="rounded-full bg-gray-100 aspect-square leading-normal">
							<a href="#sale" class="flex items-center justify-center h-full">
								<span class="block text-green">
									<Icon icon="mdi:sign-text" width="2em" height="2em" />
								</span>
							</a>
						</div>
					</div>
					<div class="text-center" id="sale">
						<a href="#sale" class="no-underline">
							<div class="font-bold text-xl text-white">Fall Yardsale</div>
							<div class="text-base text-gray-400">Sept 15-16</div>
						</a>
					</div>
				</div>
			</div>

			<div class="lg:w-1/3 p-4">
				<div>
					<div class="w-50 mx-auto max-w-[4rem] mb-8">
						<div class="rounded-full bg-gray-100 aspect-square leading-normal">
							<a href="/info/#trash" class="flex items-center justify-center h-full">
								<span class="block text-green">
									<Icon icon="mdi:delete-empty" width="2em" height="2em" />
								</span>
							</a>
						</div>
					</div>
					<div class="text-center">
						<a href="/info/#trash" class="no-underline">
							<div class="font-bold text-xl text-white">Trash Pickup</div>
							<div class="text-base text-gray-400">816-388-9739</div>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
