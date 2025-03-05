<script lang="ts">
	import Form from '$lib/form/form.svelte';
	import Title from '$lib/ui/title.svelte';

	const YEAR = new Date().getFullYear();
</script>

<Title>Officers</Title>

<p>
	The {YEAR} Board of Directors consists of the following members.&nbsp;
	<a href="/contact-us">Please contact any Board Member with any questions or concerns.</a>
</p>

<p>
	President - Mark McPherson
	<br />
	VP - Vann Martin
	<br />
	Treasurer - Rob Metcalf
	<br />
	Secretary - Judy Martin
	<br />
	Website/Directory - Katherine Curtis
	<br />
	Landscaping - John Crone
	<br />
	Social - Mark Weber
	<br />
	Todd Pratt - Member
	<br />
	Monty Tranbarger - Member
</p>

<p>Be sure to check out the board meeting schedule. All meetings are open to the homeowners.</p>

<p>
	<strong>
		For Title Company inquiries regarding dues status, please fill out the form below.
	</strong>
</p>

<Form inquiry="Title Company" />
