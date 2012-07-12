/**
 * @version SVN: $Id$
 * @package    L0gVi3w
 * @subpackage JavaScript
 * @author     Nikolai Plath {@link http://nik-it.de}
 * @author     Created on 17-Jul-2011
 * @license    GNU/GPL
 */

var pollRequest = new Request.JSON({
    method:'post',
    url:'index.php?option=com_l0gvi3w&task=pollLog&format=raw',
    initialDelay:50,
    delay:2000,
    limit:15000,

    onRequest:function () {
        document.id('pollStatus').set('text', 'running...');
    },

    onSuccess:function (response) {
        document.id('pollLog').set('html', response.text);

        var status = (0 === response.status) ? 'paused' : response.status;

        document.id('pollStatus').set('text', status);
    },

    onFailure:function () {
        document.id('pollStatus').set('text', 'Sorry, your request failed :(');
    }
});

function startPoll() {
    pollRequest.startTimer();
    document.id('l0gvi3wStart').addClass('active');
    document.id('l0gvi3wStop').removeClass('active');
}

function stopPoll() {
    pollRequest.stopTimer();

    document.id('l0gvi3wStart').removeClass('active');
    document.id('l0gvi3wStop').addClass('active');
    document.id('pollStatus').set('text', 'idle');
}
