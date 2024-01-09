import Swal from "sweetalert2/dist/sweetalert2";

export default class Sweetalert2 {
    static install(vue, options = {}) {
        const swalFunction = (...args) => {
            args.forEach((value) => {
                if (typeof value.confirmButtonClass !== "undefined") {
                    options.customClass.confirmButton =
                        typeof value.confirmButtonClass !== "string"
                            ? value.confirmButtonClass
                            : value.confirmButtonClass.split(" ");
                }

                if (typeof value.cancelButtonClass !== "undefined") {
                    options.customClass.cancelButton =
                        typeof value.cancelButtonClass !== "string"
                            ? value.cancelButtonClass
                            : value.cancelButtonClass.split(" ");
                }
            });
            return swalLocalInstance.fire.call(swalLocalInstance, ...args);
        };

        const swalLocalInstance = Swal.mixin(options);

        Object.assign(swalFunction, Swal);
        Object.keys(Swal)
            .filter((key) => typeof Swal[key] === "function")
            .forEach((methodName) => {
                swalFunction[methodName] =
                    swalLocalInstance[methodName].bind(swalLocalInstance);
            });
        vue.config.globalProperties.$swal = swalFunction;
        vue.provide("$swal", swalFunction);
    }
}
