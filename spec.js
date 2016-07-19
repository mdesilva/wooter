describe('Wooter App', function() {
    it('should have a title', function() {
        browser.get('http://woozard.dev');

        expect(browser.getTitle()).toEqual("Home Title | Wooter");
    });
});