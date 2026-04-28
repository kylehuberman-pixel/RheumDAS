//refs 
const allQuestions = document.querySelector('#HAQ-DI');
const inputAction = document.getElementById('HAQ-DI-action');
const form = document.getElementById('HAQ-DI');
const formsFooter = document.getElementById('forms');
const refScoresInput = document.getElementById('score-input-value');
const titlePositoinTop = $('#HAQ-DI-fixed-title').offset()?.top ?? 0;

$.fn.serializeControls = function () {
    const data = {};

    function buildInputObject(arr, val) {
        if (arr.length < 1)
            return val;
        let objkey = arr[0];
        if (objkey.slice(-1) == "]") {
            objkey = objkey.slice(0, -1);
        }
        let result = {};
        if (arr.length == 1) {
            result[objkey] = val;
        } else {
            arr.shift();
            let nestedVal = buildInputObject(arr, val);
            result[objkey] = nestedVal;
        }
        return result;
    }

    $.each(this.serializeArray(), function () {
        var val = this.value;
        var c = this.name.split("[");
        var a = buildInputObject(c, val);
        $.extend(true, data, a);
    });

    return data;
}

function calculateScores() {

    if (!qustionValidate(form)) return false;

    const data = $(form).serializeControls();
    const questions = Object.values(data.questions);
    let scores = 0;

    const radioScores = questions
        .filter(row => (row.type === 'radio' && row.block))
        .map(row => ({ [row.title]: Math.max(...Object.values(row.block).map(i => parseInt(i))) }))
        .reduce((acc, row) => ({ ...acc, ...row }), {});

    const checkboxScores = questions
        .filter(row => (row.type === 'checkbox' && row.block))
        .reduce((acc, row) => ({
            ...acc,
            ...Object.entries(row.block)
                .map(([title, row]) => ({
                    scores: 2,
                    answers: Object.values(row).filter((r, i, arr) => arr.indexOf(r) === i)
                })).reduce((acc, row, i, arr) => ({
                    ...acc,
                    ...row?.answers?.reduce((a, r, i) => {
                        if (!acc[r]) acc[r] = 0;
                        acc[r] += row.scores;

                        if (acc[r] > 3) acc[r] = 3;

                        return acc;
                    }, {})
                }), {})
        }), {});

    const totalScoresBySelection = Object.entries(radioScores).map(([title, row]) => {
        if (!checkboxScores[title])
            return row;
        if (checkboxScores[title] > row)
            return checkboxScores[title];
        return row;
    });

    refScoresInput.value = totalScoresBySelection.reduce((acc, row, i, arr) => {
        if (i >= arr.length - 1) return ((acc + row) / arr.length).toFixed(2);
        return acc + row;
    });
};

function swap(node1, node2) {
    var node1Next = node1.nextElementSibling;
    if (node1Next == node2) {
        node1.parentNode.insertBefore(node2, node1);
        return;
    }

    node1.parentNode.insertBefore(node2.parentNode.replaceChild(node1, node2), node1Next);
}

function submitForm(type) {
    if (confirm("Are you sure?")) {
        let valid = true;
        if (type == 'print') {
            inputAction.value = type;
            $(form).submit();
            return;
        } else if (type == 'send') {
            $('.HAQ-DI-personal-details[data-tab="email"] input[name="email"]').each((index, el) => {
                if (!el.value) {
                    el.classList.add('error');
                    valid = false;
                }
                else el.classList.remove('error');
            });
        } else if (type == 'specialist') {
            $('.HAQ-DI-personal-details[data-tab="specialist"] input[type="text"]:not([name="healthcare"],[name="birth"]), .HAQ-DI-personal-details[data-tab="specialist"] select')
                .each((index, el) => {
                    if (!el.value || el.value == '0') {
                        el.classList.add('error');
                        valid = false;
                    }
                    else el.classList.remove('error');
                });

            if (valid) {
                valid = false;
                $('.HAQ-DI-personal-details[data-tab="specialist"] input[name="healthcare"], .HAQ-DI-personal-details[data-tab="specialist"] input[name="birth"]').each((index, el) => {
                    if (!el.value) {
                        el.classList.add('error');
                    } else {
                        valid = true;
                        return false;
                    }
                });
            }
        }
        if (valid) {
            inputAction.value = type;
            $.post('actions.php', $(form).serializeControls(), res => {
                popupNotification(res, res === 'Message has been sent');
            }).fail(function () {
                popupNotification('Oops!', false);
            });
        }
    }
}

function openTab(el, tab) {
    $("input.active[type=button]").removeClass('active');
    $(el).addClass('active');
    $('.HAQ-form-tabs div.active').removeClass('active');
    $('.HAQ-form-tabs div[data-tab="' + tab + '"]').addClass('active');
}

function qustionValidate(form, showError = true) {
    const data = $(form).serializeControls();

    const questions = Object.values(data.questions);

    const listToScroll = [];
    $('.required').remove();
    $(form).find('.HAQ-DI-block').each((index, el) => {
        if ($(el).data().required == '1') {

            const question = questions.find(row => row.title == $(el).find('.HAQ-DI-title')[0].childNodes[0].nodeValue);
            const amountQuestionInBlock = $(el).find('.HAQ-DI-body lable').length;
            if (
                !question ||
                (question && !question.block) ||
                (question && question.block && Object.values(question.block).length != amountQuestionInBlock)
            ) {
                if (showError)
                    $(el).find('.HAQ-DI-title').append('<span class="required">*This question is required to generate your score. Please select your answer below.</span>');

                listToScroll.push($(el).offset().top - 190);
            }
        }
    });

    if (listToScroll.length) {
        if (showError) {
            $([document.documentElement, document.body])
                .animate({ scrollTop: Math.min(...listToScroll) }, 2000);
        }

        return false;
    }

    return true;
}

$(".HAQ-DI-questions-slider input[type=text]").on('change', (e) => {
    let value = e.target.value;
    const lable = e.target.closest('lable');
    const range = $(lable.querySelector('.slider')).data();

    if (value > range.max) value = range.max;
    if (value < range.min) value = range.min;

    e.target.value = value;

    $(lable.querySelector('.slider')).slider("value", value);
});

$(".HAQ-DI-body .slider").each((index, row) => {

    $(row).slider({
        min: $(row).data().min,
        max: $(row).data().max,
        step: 1,
        change: e => {
            if (!e.toElement) return;

            const lable = e.toElement.closest('lable');
            if (lable)
                lable.querySelector('input[type=text]').value = $(e.toElement.closest('lable').querySelector('.slider')).slider("value");
        }
    })
        .slider("pips", {
            step: 1,
            labels: { first: "", last: "" }
        })
        .slider("float");
});

$(window).on('scroll', e => {
    if (window.scrollY >= titlePositoinTop && !$('#HAQ-DI-fixed-title')[0]?.closest('.HAQ-DI-fixed-title')) {
        $('#HAQ-DI-fixed-title').addClass('HAQ-DI-fixed-title');
        $('#HAQ-DI-wrapper').css('margin-top', '210px');
    } else if (window.scrollY < titlePositoinTop && $('#HAQ-DI-fixed-title')[0]?.closest('.HAQ-DI-fixed-title')) {
        $('#HAQ-DI-fixed-title').removeClass('HAQ-DI-fixed-title');
        $('#HAQ-DI-wrapper').css('margin-top', 'auto');
    }

});

$('input[type=number]').on('input propertychange', e => {
    const el = e.target;
    if (el.value > +$(el).attr('max')) el.value = $(el).attr('max');
    if (el.value < +$(el).attr('min')) el.value = $(el).attr('min');
});

$('input[type="checkbox"]').on('keydown', e => {
    e.preventDefault();
    if (e.keyCode == 13) {
        $(e.target).prop('checked', !$(e.target).prop('checked'));
    }
});

let sizeWindow = window.innerWidth;

if (window.innerWidth <= 980) {
    $('.HAQ-DI-questions-radio').each((index, el) => {
        swap($(el).find('.HAQ-DI-questions-description')[0], $(el).find('.HAQ-DI-head')[0]);
    });
}

$(window).on('resize', (e) => {
    if (
        (window.innerWidth <= 980 && sizeWindow > 980) ||
        (window.innerWidth > 980 && sizeWindow <= 980)
    ) {
        sizeWindow = window.innerWidth;
        $('.HAQ-DI-questions-radio').each((index, el) => {
            swap($(el).find('.HAQ-DI-questions-description')[0], $(el).find('.HAQ-DI-head')[0]);
        });
    }
});

function popupNotification(text, status = true) {
    $(formsFooter).append('<div class="popup-notify-in-top ' + (status ? "success" : "error") + '">' + text + '</div>');

    setTimeout(() => { $('.popup-notify-in-top').remove() }, 10000)
}
