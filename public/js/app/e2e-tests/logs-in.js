describe('Wooter', function() {
    it('should log in into a user account', function() {
        browser.get('http://woozard.dev');

        expect(browser.getTitle()).toEqual("Home Title | Wooter");

        element(by.css('a[ui-sref=login]')).click();

        element(by.id('formly_1_input_email_0')).sendKeys('carlos@wooter.co');
        element(by.id('formly_1_input_password_1')).sendKeys('carlos123');

        element(by.id('login-button')).click();

    });
});