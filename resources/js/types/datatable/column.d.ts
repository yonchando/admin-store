export interface Component {
    el: any;
    label: string;
    props?: any;
}

export interface Column {
    label: string;
    field?: string | any;
    props?: any;
    component?: Component;
}
