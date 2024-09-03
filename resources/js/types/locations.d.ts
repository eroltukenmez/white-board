export interface Location {
    id: number
    name: string
    parent_id?: number
    children: Location[]
    parent?: Location
}
