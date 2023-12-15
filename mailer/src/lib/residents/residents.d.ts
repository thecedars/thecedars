export interface Resident {
	StreetNumber: string;
	StreetName: string;
	City: string;
	State: string;
	Zip: string;
	LastName: string;
	ListingName: string;
	Phone: string;
	Children: string;
	Email: string;
	Notes: string;
	BillingAddress: string;
	BillingPhone: string;
	BillingEmail: string;
	Flag_Print: string;
	Flag_OptionalBilling: string;
	Flag_HideEmail: string;
}

export type Residents = Resident[];
