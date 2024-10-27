export interface Component {
    el: any;
    label: string;
    props?: any;
}

export interface Column {
    label: string;
    field?: any;
    props?: any;
    sortable: boolean;
    component?: Component;
}
