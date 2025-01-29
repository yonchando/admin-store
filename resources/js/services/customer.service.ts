import { ColumnType } from "@/types/datatable/column";
import { Module } from "@/types/models/module";
import Badge from "@/Components/Badges/Badge.vue";
import { globalFilter } from "@/services/helper.service";
import { Customer } from "@/types/models/customer";
import axios, { AxiosResponse } from "axios";
import { defineStore } from "pinia";
import { Paginate } from "@/types/paginate";
import { phoneNumber } from "@/number_format";
import Select from "@/Components/Forms/Select.vue";

export default class CustomerService {
    static filters = {};
    static columns: ColumnType<Customer>[] = [
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

    static statuses = {
        active: "active",
        inactive: "inactive",
    };

    static getData(): Promise<AxiosResponse<Paginate<Customer>>> {
        return axios.get(route("customer.index"));
    }
}
