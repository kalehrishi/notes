$.get('../../template/template.mustache', function(template) {
        var rendered = Mustache.render(template, {});
        $('body').append(rendered);
    });