/**
 * Created by Eric Rho.
 * User: slack: erho87 skype: eric.rho
 * For: {package}
 * License: Wooter LLC.
 * Date: 2016.05.06
 * Description:
 *
 */
"use strict";
function sortBy (argument) {
	var fields = [].slice.call(arguments),
		n_fields = fields.length;

	return function(A, B) {
		var a, b, field, key, primer, reverse, result;
		for (var i = 0, l = n_fields; i < l; i++) {
			result = 0;
			field = fields[i];

			key = typeof field === 'string' ? field : field.name;

			a = A[key];
			b = B[key];

			if (typeof field.primer !== 'undefined') {
				a = field.primer(a);
				b = field.primer(b);
	      	}

			reverse = (field.reverse) ? -1 : 1;

			if (a < b) result = reverse * -1;
			if (a > b) result = reverse * 1;
			if (result !== 0) break;
		}
		return result;
	};
}