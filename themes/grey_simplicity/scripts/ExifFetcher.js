function ExifFetcher(url) {

	this.req = null;

	this.fetchExif = function(folder, image)
	{
		this.createXhr();
		var req = this.req;
		var fetcher = this;
		req.onreadystatechange = function()
		{
			if (req.readyState == 4) 
			{
				if (req.status == 200) 
				{
					fetcher.onsuccess(req);
				}
				if ( req.status.toString().startsWith('4') || req.status.toString().startsWith('5') )
				{
					fetcher.onerror(req);
				}
			}
		}

		targetUrl = url + '?album=' + folder + '&image=' + image;
		req.open("GET", targetUrl, true);
		req.send(null);	
	}

	
	this.onsuccess = function(req) { }
	this.onerror = function(req) { }

	this.createXhr = function()
	{
		if ( this.req != null ) 
		{
			return;
		}
		
		if (window.XMLHttpRequest) 
		{
			this.req = new XMLHttpRequest();
		 
			if (this.req.overrideMimeType) 
			{
				this.req.overrideMimeType("text/xml");
			}
		} 
		else 
		{
		   if (window.ActiveXObject) 
		   {
				try 
				{ 
					this.req = new ActiveXObject("Msxml2.XMLHTTP");
				} 
				catch (e) 
				{
					try 
					{ 
						this.req = new ActiveXObject("Microsoft.XMLHTTP");
					} 
					catch (e) 
					{
						
					} 
				}
			}
		}
	}
}