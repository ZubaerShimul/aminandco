let mobileUtil;
mobileUtil = (selector, script, country = '') => {
    let phone = document.querySelector(selector);

    window.intlTelInput(phone, {
        allowDropdown: true,
        autoHideDialCode: true,
        autoPlaceholder: "on",
        dropdownContainer: document.body,
        initialCountry: country === '' ? 'CH' : country,
        formatOnDisplay: true,
        hiddenInput: "phone",
        nationalMode: false,
        placeholderNumberType: "MOBILE",
        separateDialCode: false,
        utilsScript: script,
    });
}

