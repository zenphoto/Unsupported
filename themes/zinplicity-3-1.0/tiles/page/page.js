Zen.override(Zen.theme.Page, {
	page: function(target, params) {
		var p = $('#internal-page-titlelink').text();
		if (p && this.extensions[p.toLowerCase()] ) {
			this.extensions[p.toLowerCase()].call(this);
		}
	}
});
