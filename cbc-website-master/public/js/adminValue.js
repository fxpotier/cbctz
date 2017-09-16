/**
 * Created by Marc on 10/08/2015.
 */

angular.module('cbc').value('calendar', {
	getEvents: '/backoffice/experience/calendar-events/',
	postEvents: '/backoffice/experience/calendar/',
	redirect:'/backoffice/experience/index'
});