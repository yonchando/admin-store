import { ColumnType } from "@/types/datatable/column";
import { Module } from "@/types/models/module";
import Badge from "@/Components/Badges/Badge.vue";
import { globalFilter } from "@/services/helper.service";
import { Customer } from "@/types/models/customer";
import axios from "axios";
import { defineStore } from "pinia";
import { Paginate } from "@/types/paginate";
import { phoneNumber } from "@/number_format";
import Select from "@/Components/Forms/Select.vue";

export const columns: ColumnType<Customer>[] = [
    {
        label: "Name",
        field: "name",
        sortable: "name",
    },
    {
        label: "Email",
        field: "email",
        sortable: "email",
    },
    {
        label: "Phone number",
        field: (c) => phoneNumber(c.phone_number, c.country_code),
        sortable: "phone_number",
    },
    {
        label: "Gender",
        field: (customer) => __(customer.gender),
        props: {
            class: "w-32",
        },
        filters: {
            field: "gender",
            component: {
                el: Select,
                props: {
                    options: [
                        { id: "male", name: "Male" },
                        { id: "female", name: "Female" },
                    ],
                },
            },
        },
    },
    {
        label: "Status",
        field: (value) => __(value.status),
        component: {
            el: Badge,
            props: (item: Module) => {
                return {
                    severity: item.status === "active" ? "info" : "warning",
                };
            },
        },
        filters: {
            field: "status",
            component: {
                el: Select,
                props: {
                    options: ["active", "inactive"],
                    optionLabel: function (option: string) {
                        return __(option);
                    },
                },
            },
        },
        props: {
            class: "w-32",
        },
    },
    {
        label: "Created date",
        field: "created_at",
        props: {
            class: "w-48",
        },
    },
    {
        label: "Updated date",
        field: "updated_at",
        props: {
            class: "w-32",
        },
        hideFromIndex: true,
    },
];

export const filters = {};

export const statuses = {
    active: "active",
    inactive: "inactive",
};

export default {
    columns,
    filters,
};

export const useCustomerStore = defineStore("customer", {
    state: () => {
        return {
            data: [] as Customer[],
            paginate: {} as Paginate<Customer>,
            filters: {
                ...globalFilter,
            },
            loading: false,
            debounce: null as any,
        };
    },
    actions: {
        getData(more: boolean = false) {
            if (this.data.length > 0 && !more) {
                return;
            }
            this.loading = true;
            axios
                .get(route("customer.index", this.filters))
                .then((res) => {
                    this.paginate = res.data;

                    if (more) {
                        this.data = [...this.data, ...res.data.data];
                    } else {
                        this.data = res.data.data;
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        search(value: string) {
            this.filters.search = value;

            if (this.debounce) {
                clearTimeout(this.debounce);
            }

            this.debounce = setTimeout(() => {
                this.getData();
            }, 500);
        },
        more() {
            this.filters.page = this.paginate.current_page + 1;
            this.getData(true);
        },
        isLastPage() {
            return this.paginate.next_page_url != null;
        },
    },
});
