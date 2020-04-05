export interface ConsumerProduct {
	id: number
	name: string
	description: string
	price: number
	platform: string
	resolution: string
	refresh_rate: string
	audio_type: string
	included_info: string
	colour: string
	warranty: string
	ean: string
	sku: string
	brand: string
	image_url: string
	in_sale: boolean
	point_of_view: string
	height: string
	width: string
  own_display: string
  is_active: boolean
}

export const ProductValueTypes: {
	id      : keyof ConsumerProduct
	name    : string
	type    : 'string' | 'number' | 'image' | 'boolean' | 'longText'
	required: boolean
}[] = [
	{
		id      : 'name',
		name    : 'Naam',
		type    : 'string',
		required: true
  },
  {
		id      : 'price',
		name    : 'Prijs',
		type    : 'number',
		required: true
  },
  {
		id      : 'description',
		name    : 'Beschrijving',
		type    : 'longText',
		required: false
  },
  {
		id      : 'platform',
		name    : 'Platform',
		type    : 'string',
		required: false
  },
  {
		id      : 'included_info',
		name    : 'Bijgeleverde items',
		type    : 'longText',
		required: false
  },
  {
		id      : 'image_url',
		name    : 'Foto',
		type    : 'image',
		required: true
  },
  {
		id      : 'resolution',
		name    : 'Resolutie',
		type    : 'string',
		required: false
  },
  {
		id      : 'refresh_rate',
		name    : 'Refresh Rate',
		type    : 'string',
		required: false
  },
  {
		id      : 'colour',
		name    : 'Kleur',
		type    : 'string',
		required: false
  },
  {
		id      : 'warranty',
		name    : 'Garantie',
		type    : 'string',
		required: false
  },
  {
		id      : 'point_of_view',
		name    : 'Gezichtsveld',
		type    : 'string',
		required: false
  },
  {
		id      : 'height',
		name    : 'Hoogte',
		type    : 'string',
		required: false
  },
  {
		id      : 'width',
		name    : 'Breedte',
		type    : 'string',
		required: false
  },
  {
		id      : 'brand',
		name    : 'Merk',
		type    : 'string',
		required: false
  },
  {
		id      : 'ean',
		name    : 'EAN',
		type    : 'string',
		required: false
  },
  {
		id      : 'sku',
		name    : 'SKU',
		type    : 'string',
		required: false
  },
  {
		id      : 'in_sale',
		name    : 'In de aanbieding',
		type    : 'boolean',
		required: false
  },
  {
		id      : 'own_display',
		name    : 'Eigen display',
		type    : 'boolean',
		required: false
  },
  {
	id      : 'is_active',
	name    : 'Actief in verkoop',
	type    : 'boolean',
	required: false
},

]
