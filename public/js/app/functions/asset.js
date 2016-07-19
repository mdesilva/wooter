/**
 * Created by Dumitrana Alinus.
 * User: alin.designstudio
 * For: Asset function
 * License: Wooter LLC.
 * Date: 26.12.2015
 * Description: Asset function to create url for assets
 *
 */
function $asset($a){
    var host = "{protocol}://{host}/{asset}";
    var data = {
        protocol: window.location.protocol.replace(/\:/g, ''),
        host: window.location.host,
        asset: $a
    };

    return tpl(host, data);
}
