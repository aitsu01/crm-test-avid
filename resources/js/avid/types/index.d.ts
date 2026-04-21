import { Schema } from "./widget";

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type BreadcrumbItemType = BreadcrumbItem;

export interface Breadcrumb {
    label: string;
    url: string | null;
}

export interface Page {
    title: string | null;
    subtitle: string | null;
    description: string | null;
    keywords: string | null;
    home: string;
    hideTitleBar: boolean;
    breadcrumbs: Breadcrumb[];
    size: 'xs' | 'sm' | 'md' | 'lg' | 'xl' | 'xxl' | 'full';
    widgets: Schema[];
}

export interface Notification {
    id: string;
    status: 'info' | 'success' | 'warning' | 'danger';
    title?: string;
    body?: string;
    duration: number;
}

export interface DatabaseNotification {
    id: string;
    status: 'info' | 'success' | 'warning' | 'danger';
    title?: string;
    body?: string;
    url?: string;
    color: string;
    icon: string;
    created_at: string;
}

export interface SidebarGroup {
    id: string;
    title: string;
    hidden: boolean;
    children: SidebarItem[];
}

export interface SidebarItem {
    id: string;
    title: string;
    route?: string;
    link?: string;
    icon?: string;
    active: boolean;
}

export interface Avid {
    settings: {
        routePrefix: string;
        logo: {
            light: {
                auth: string;
                sidebar: string;
            };
            dark: {
                auth: string;
                sidebar: string;
            };
        };
        isNotificationEnabled: boolean;
        canDeleteAccount: boolean;
        canUpdatePassword: boolean;
        canUpdateProfile: boolean;
        canUpdateLocale: boolean;
        locales: Option[];
    };
    page: Page;
    notifications: Notification[];
    sidebar: SidebarGroup[];
    settingsSidebar?: SidebarGroup[];
    unreadNotifications: number;
}

export interface Option {
    key: any;
    label: string;
    color?: string;
    icon?: string;
    payload: any;
    labelTemplate?: string;
    children?: Option[];
}
