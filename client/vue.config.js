module.exports = {
	// ...other vue-cli plugin options...
	pwa: {
		name: 'My App',
		themeColor: '#bb6b00',
		msTileColor: '#000000',
		appleMobileWebAppCapable: 'yes',
		appleMobileWebAppStatusBarStyle: 'black',
		// configure the workbox plugin
		workboxPluginMode: 'InjectManifest',
		workboxOptions: {
			// swSrc is required in InjectManifest mode.
			swSrc: 'dev/sw.js',
			// ...other Workbox options...
		},
		iconPaths: {
			favicon32: 'img/icons/chip_coffee.png',
			favicon16: 'img/icons/chip_coffee.png',
			appleTouchIcon: 'img/icons/chip_coffee.png',
			maskIcon: 'img/icons/chip_coffee.png',
			msTileImage: 'img/icons/chip_coffee.png'
		}
	}
};