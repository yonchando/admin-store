import Swal from 'sweetalert2/dist/sweetalert2.js';

export default class Sweetalert2 {
    static install(vue, options = {}) {
        const swalLocalInstance = Swal.mixin(options);
        const swalFunction = function (...args) {

            args.forEach((value, key) => {
                let customClass = {
                    confirmButton: ['btn', 'btn-primary'],
                    cancelClass: ['btn', 'btn-light']
                };

                if (value.confirmButtonClass) {
                    customClass.confirmButton = typeof value.confirmButtonClass === 'string' ? value.confirmButtonClass.split(' ') : value.confirmButtonClass;
                }

                if (value.cancelButtonClass) {
                    customClass.cancelButton = typeof value.cancelButtonClass === 'string' ? value.cancelButtonClass.split(' ') : value.cancelButtonClass
                }

                args[key].customClass = customClass;
            });

            return swalLocalInstance.fire.call(swalLocalInstance, ...args);
        };
        Object.assign(swalFunction, Swal);
        Object.keys(Swal)
            .filter(key => typeof Swal[key] === 'function')
            .forEach(methodName => {
                swalFunction[methodName] = swalLocalInstance[methodName].bind(swalLocalInstance);
            });
        vue.config.globalProperties.$swal = swalFunction;
        vue.provide('$swal', swalFunction);
    }
}