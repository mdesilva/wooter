/*
 * Created by Dumitrana Alinus
 * User: alin.designstudio
 * For: Store data on Local or session storage
 * License: Wooter LLC.
 * Date: 2016.01.25
 * Description: STORE is a factory to manage Local and Session storage and manipulate
 *              all items from this.
 *
 * Using: STORE('local', 'today', 'sunny') | Set item to localStorage with name today and value sunny
 *        STORE('local', 'today') | Get value of item from localStorage with name today
 *        STORE() | Get factory instaces (create (get, store), check, up
 *
 */
__Wooter.factory('STORE', ['$window', '$http', '$q', function($window, $http, $q){
    /*
     * Controller for initialize
     * @param array a Array value with arguments
     *               if arguments is more than 3 will throw error
     *               if arguments length is equal with 1 and value is true will return an instance with
     *                  methods [local(set, get, remove), session(set, get, remove)]
     *               if all are good return void (nothing)
     * @return object/void
     */
    function store (a) {
        if (a.length > 0) {
            if (a.length <= 3) {
                if (typeof a[0] == "boolean" && a[0]) {
                    return this.instances;
                } else {
                    return this.init(a);
                }
            } else {
                throw new Error('More arguments ... accept only 3 arguments (type, key, value)')
            }
        } else {
            return this.instances;
        }
    }
    var proto = store.prototype;

    /*
     * Default values for STORE factory
     */
    proto.defaults = {
        storage: 'session'
    };

    /*
     * Clean Methods
     */
    proto.Clean = {
        /*
         * Getting arguments and filter values
         * @param a array
         *
         * @return object
         *
         * eg: {
         *      type: 'local/session',
         *      key: 'name_of_item',
         *      value: 'value_of_item'
         * }
         */
        args: function (a) {
            var $return = {};

            if(a[0] == 'session' || a[0] == 'local' || a[0] == 'sessionStorage' || a[0] == 'localStorage'){
                if(a[0] == 'session' || a[0] == 'sessionStorage'){
                    $return.type = "session";
                } else {
                    $return.type = "local";
                }
                $return.key = proto.Clean.string(a[1]);
                $return.val = (a[2])?proto.Clean.object(a[2]):undefined;
            } else {
                $return.type = proto.defaults.storage;
                $return.key = proto.Clean.string(a[0]);
                $return.val = (a[1])?proto.Clean.object(a[1]):undefined;
            }

            return $return;
        },
        /*
         * Clean Objects/Arrays
         * @param a mixed
         *
         * @return string/number
         */
        object: function(a){
            return (typeof a == "object" || typeof a == "array")?JSON.stringify(a):a;
        },
        string: function(a){
            return a.toString();
        }
    };

    /*
    *   Get arguments, filtering and execute
    *
    *   First argument is considered type of storage (local or session) or key (if called with 2 arguments and type will be default 'session')
    *   Second argument is considered key for item who will be stored or fetched or value (if called with 2 arguments and type will be default 'session')
    *   Third argument is considered value for item who will be stored
    *
    *   If Value argument is missing ( eg: Store('session', 'key_of_value') )
    *       will return value of item from sessionStorage where=key_of_value
    *   If all arguments are good ( eg: Store('local', 'key_of_value', 'value_of_key') )
    *       will return void and will set item localStorage with value = value_of_key
    *
    *   @param object args : arguments of plugin
    *
    *   @return string
    */
    proto.init = function(args){
        var param = proto.Clean.args(args);

        if (param.val){
            proto.store(param.type, param.key, param.val);
        } else {
            return proto.get(param.type, param.key);
        }
    };

    /*
     * Store Item to storage
     *
     * @param string t : [local, session] Type of storage (localStorage or sessionStorage)
     * @param string k : name of key from storage
     * @param string v : value of item who will be stored
     *
     * @return void
     */
    proto.store = function (t, k, v) {
        proto.Storage.methods[t].set(k, v);
    };

    /*
     * Get Item to storage
     *
     * @param string t : [local, session] Type of storage (localStorage or sessionStorage)
     * @param string k : name of key from storage
     *
     * @return string
     */
    proto.get = function (t, k) {
        proto.Storage[t].get(k);
    };

    /*
     * Store Methods
     */
    proto.Storage = {
        methods: {
            session: {
                set: function(k,v){
                    sessionStorage.setItem(k,proto.Clean.object(v));
                },
                get: function(k){
                    var val = sessionStorage.getItem(k);

                    if(val === null && typeof val === "object"){
                        return undefined
                    } else {
                        if(val.toString().trim().toLowerCase() != 'undefined'){
                            val = (val.trim().toLowerCase() == 'true' || val.trim().toLowerCase() == 'false' ) ? angular.fromJson("[" + val.trim().toLowerCase() + "]")[0] : val;
                        } else {
                            val = undefined;
                        }
                        return val;
                    }
                },
                check: function(k){
                    return (k in sessionStorage);
                },
                destroy: function(k){
                    sessionStorage.removeItem(k);
                }
            },
            local: {
                set: function(k,v){
                    localStorage.setItem(k,proto.Clean.object(v));
                },
                check: function(k){
                    return (k in localStorage);
                },
                get: function(k){
                    var val = localStorage.getItem(k);

                    if(val === null && typeof val === "object"){
                        return undefined
                    } else {
                        if(val.toString().trim().toLowerCase() != 'undefined'){
                            val = (val.trim().toLowerCase() == 'true' || val.trim().toLowerCase() == 'false' ) ? angular.fromJson("[" + val.trim().toLowerCase() + "]")[0] : val;
                        } else {
                            val = undefined;
                        }
                        return val;
                    }
                },
                destroy: function(k){
                    localStorage.removeItem(k);
                }
            }
        }
    };

    /*
     * Plugin instances
     */
    proto.instances = {
        session: {
            create: function(k,v){
                proto.Storage.methods.session.set(k, v);
            },
            check: function(k){
                return proto.Storage.methods.session.check(k);
            },
            show: function(k){
                return proto.Storage.methods.session.get(k);
            },
            delete: function(k){
                proto.Storage.methods.session.destroy(k);
            }
        },
        local: {
            create: function(k,v){
                proto.Storage.methods.local.set(k, v);
            },
            check: function(k){
                return proto.Storage.methods.local.check(k);
            },
            show: function(k){
                return proto.Storage.methods.local.get(k);
            },
            delete: function(k){
                proto.Storage.methods.local.destroy(k);
            }
        }
    };

    proto.instances.session.store = proto.instances.session.create;
    proto.instances.session.set = proto.instances.session.create;
    proto.instances.session.update = proto.instances.session.create;
    proto.instances.session.get = proto.instances.session.show;
    proto.instances.session.remove = proto.instances.session.delete;
    proto.instances.session.destroy = proto.instances.session.delete;

    proto.instances.local.store = proto.instances.local.create;
    proto.instances.local.set = proto.instances.local.create;
    proto.instances.local.update = proto.instances.local.create;
    proto.instances.local.get = proto.instances.local.show;
    proto.instances.local.remove = proto.instances.local.delete;
    proto.instances.local.destroy = proto.instances.local.delete;

    return function (){
        var b = new store(arguments);
        return b;
    };
}]);