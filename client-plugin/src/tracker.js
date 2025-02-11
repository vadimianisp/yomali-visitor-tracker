(function () {
	const scriptTag = document.currentScript;
	const WEBSITE_KEY = scriptTag.getAttribute("data-key"); // Extract website_key
	const TRACKING_API = "http://localhost:8080/api/track"; // Change for production
	
	if (!WEBSITE_KEY) {
		console.warn("Visitor Tracker: Missing 'data-key' in script tag.");
		return;
	}
	
	// Generate a persistent visitor_id using localStorage
	function getVisitorId() {
		let visitorId = localStorage.getItem("visitor_id");
		if (!visitorId) {
			visitorId = "visitor_" + Math.random().toString(36).substr(2, 10);
			localStorage.setItem("visitor_id", visitorId);
		}
		return visitorId;
	}
	
	function getVisitorData() {
		const currentURL = window.location.href.startsWith("file://")
			? "localhost/test"
			: window.location.href;
		
		return {
			api_key: WEBSITE_KEY,
			visitor_id: getVisitorId(),
			visitor_ip: null, // IP is set on the backend
			user_agent: navigator.userAgent,
			browser: getBrowser(),
			device: getDeviceType(),
			os: getOS(),
			screen_resolution: `${window.screen.width}x${window.screen.height}`,
			page_url: currentURL,
			referrer: document.referrer || null,
			fingerprint: getDeviceFingerprint(),
			timestamp: Math.floor(Date.now() / 1000)
		};
	}
	
	function sendTrackingData() {
		const visitorData = getVisitorData();
		console.log("Tracking data:", visitorData);
		
		if (navigator.sendBeacon) {
			navigator.sendBeacon(TRACKING_API, JSON.stringify(visitorData));
		} else {
			fetch(TRACKING_API, {
				method: "POST",
				headers: { "Content-Type": "application/json" },
				body: JSON.stringify(visitorData)
			})
				.then(response => response.json())
				.then(data => console.log("Tracking successful:", data))
				.catch(error => console.error("Tracking failed:", error));
		}
	}
	
	function getBrowser() {
		const ua = navigator.userAgent;
		if (ua.includes("Chrome")) return "Chrome";
		if (ua.includes("Firefox")) return "Firefox";
		if (ua.includes("Safari") && !ua.includes("Chrome")) return "Safari";
		if (ua.includes("Edge")) return "Edge";
		if (ua.includes("MSIE") || ua.includes("Trident")) return "IE";
		return "Unknown";
	}
	
	function getOS() {
		const ua = navigator.userAgent;
		if (ua.includes("Win")) return "Windows";
		if (ua.includes("Mac")) return "MacOS";
		if (ua.includes("Linux")) return "Linux";
		if (ua.includes("Android")) return "Android";
		if (ua.includes("iOS") || ua.includes("iPhone") || ua.includes("iPad")) return "iOS";
		return "Unknown";
	}
	
	function getDeviceType() {
		return /Mobi|Android/i.test(navigator.userAgent) ? "Mobile" : "Desktop";
	}
	
	// Simple fingerprinting method
	function getDeviceFingerprint() {
		return btoa(navigator.userAgent + navigator.language + screen.width + screen.height);
	}
	
	window.addEventListener("load", sendTrackingData);
})();
