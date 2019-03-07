/**
 * standard locales. Please add more according to ISO 639-1 standard. Multiple language variants are
 * unlikely to be required. If this gets too large it can be split out into separate JS files.
 */
var locales = {
    bg_BG: {
        OK: "Ок",
        CANCEL: "Отказ",
        CONFIRM: "Потвърждавам"
    },
    br: {
        OK: "OK",
        CANCEL: "Cancelar",
        CONFIRM: "Sim"
    },
    cs: {
        OK: "OK",
        CANCEL: "Zrušit",
        CONFIRM: "Potvrdit"
    },
    da: {
        OK: "OK",
        CANCEL: "Annuller",
        CONFIRM: "Accepter"
    },
    de: {
        OK: "OK",
        CANCEL: "Abbrechen",
        CONFIRM: "Akzeptieren"
    },
    el: {
        OK: "Εντάξει",
        CANCEL: "Ακύρωση",
        CONFIRM: "Επιβεβαίωση"
    },
    en: {
        OK: "OK",
        CANCEL: "Cancel",
        CONFIRM: "OK"
    },
    es: {
        OK: "OK",
        CANCEL: "Cancelar",
        CONFIRM: "Aceptar"
    },
    et: {
        OK: "OK",
        CANCEL: "Katkesta",
        CONFIRM: "OK"
    },
    fa: {
        OK: "قبول",
        CANCEL: "لغو",
        CONFIRM: "تایید"
    },
    fi: {
        OK: "OK",
        CANCEL: "Peruuta",
        CONFIRM: "OK"
    },
    fr: {
        OK: "OK",
        CANCEL: "Annuler",
        CONFIRM: "OK"
    },
    he: {
        OK: "אישור",
        CANCEL: "ביטול",
        CONFIRM: "אישור"
    },
    hu: {
        OK: "OK",
        CANCEL: "Mégsem",
        CONFIRM: "Megerősít"
    },
    hr: {
        OK: "OK",
        CANCEL: "Odustani",
        CONFIRM: "Potvrdi"
    },
    id: {
        OK: "OK",
        CANCEL: "Batal",
        CONFIRM: "OK"
    },
    it: {
        OK: "OK",
        CANCEL: "Annulla",
        CONFIRM: "Conferma"
    },
    ja: {
        OK: "OK",
        CANCEL: "キャンセル",
        CONFIRM: "確認"
    },
    lt: {
        OK: "Gerai",
        CANCEL: "Atšaukti",
        CONFIRM: "Patvirtinti"
    },
    lv: {
        OK: "Labi",
        CANCEL: "Atcelt",
        CONFIRM: "Apstiprināt"
    },
    nl: {
        OK: "OK",
        CANCEL: "Annuleren",
        CONFIRM: "Accepteren"
    },
    no: {
        OK: "OK",
        CANCEL: "Avbryt",
        CONFIRM: "OK"
    },
    pl: {
        OK: "OK",
        CANCEL: "Anuluj",
        CONFIRM: "Potwierdź"
    },
    pt: {
        OK: "OK",
        CANCEL: "Cancelar",
        CONFIRM: "Confirmar"
    },
    ru: {
        OK: "OK",
        CANCEL: "Отмена",
        CONFIRM: "Применить"
    },
    sq: {
        OK: "OK",
        CANCEL: "Anulo",
        CONFIRM: "Prano"
    },
    sv: {
        OK: "OK",
        CANCEL: "Avbryt",
        CONFIRM: "OK"
    },
    th: {
        OK: "ตกลง",
        CANCEL: "ยกเลิก",
        CONFIRM: "ยืนยัน"
    },
    tr: {
        OK: "Tamam",
        CANCEL: "İptal",
        CONFIRM: "Onayla"
    },
    zh_CN: {
        OK: "OK",
        CANCEL: "取消",
        CONFIRM: "确认"
    },
    zh_TW: {
        OK: "OK",
        CANCEL: "取消",
        CONFIRM: "確認"
    }
};

$.each(locales, function (i, e) {
    bootbox.addLocale(i, {
        OK: e.OK,
        CANCEL: e.CANCEL,
        CONFIRM: e.CONFIRM
    });
});