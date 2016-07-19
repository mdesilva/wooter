/**
 * Created by Carlos Morales.
 * Edit by Dumitrana Alinus.
 * User: carlosmoralescliment.
 * For: Dates
 * License: Wooter LLC.
 * Date: 28.06.2016
 * Description:
 *
 */
function normalizeDatepicker (date){
    return moment(date).format('YYYY-MM-DD hh:mm:ss')
}
