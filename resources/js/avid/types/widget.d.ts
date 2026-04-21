
export interface Schema {
    id: string;
    component: string;
    type: 'layout' | 'widget';
    async: boolean;
    params: any;
    props: any;
    placeholderHeight: string;
}
