export {Location} from "@/types/locations";
export interface User {
    id: number;
    name: string;
    email: string;
    phone: string;
    email_verified_at: string;
    roles: {
        id:number;
        title:string;
    }[];
    departments: {
        id:number;
        name:string;
    }[];
}

export interface Permission {
    guard_name:string;
    id:number;
    name:string;
    title: string;
}

export interface Application {
    id: string
    user: User
    location: Location
    type: string
    description: string
    source: string
    created_at: string
}

export interface Translation extends Record<string, string> {}


export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
        permissions: Permission[]
    },
    translations:Translation;
};
