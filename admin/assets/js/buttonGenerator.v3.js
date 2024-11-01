const urlCheck = new RegExp(/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/);
const fontWeightValues = [300, 400, 600, 700, 800];
const fontWeightLabels = ['Light', 'Regular', 'Semi-bold', 'Bold', 'Extra-bold'];

const intProps = ['iconSize', 'fontSize', 'fontWeight', 'borderWidth', 'borderRadius', 'paddingHorizontal', 'paddingVertical'];
const boolProps = ['textUnderline', 'textUnderlineHover'];

const buttonStyle = {
	iconSize: '24',
	fontSize: '13',
	fontWeightSliderValue: '1',
	fontWeight: '400',
	textColor: '#000000',
	textColorHover: '#000000',
	textUnderline: false,
	textUnderlineHover: false,
	backgroundColor: '#efefef',
	backgroundColorHover: '#ffffff',
	borderWidth: '1',
	borderRadius: '3',
	borderStyle: 'solid',
	borderStyleHover: 'solid',
	borderColor: '#dadada',
	borderColorHover: '#efefef',
	paddingHorizontal: '0',
	paddingVertical: '0',
};
const linkStyle = {
	iconSize: '16',
	fontSize: '13',
	fontWeightSliderValue: '1',
	fontWeight: '400',
	textColor: '#000000',
	textColorHover: '#000000',
	textUnderline: false,
	textUnderlineHover: true,
	backgroundColor: 'transparent',
	backgroundColorHover: 'transparent',
	borderWidth: '0',
	borderRadius: '0',
	borderStyle: 'hidden',
	borderStyleHover: 'hidden',
	borderColor: 'transparent',
	borderColorHover: 'transparent',
	paddingHorizontal: '0',
	paddingVertical: '0',
};

Vue.component('colorpicker', {
	components: {
		'chrome-picker': window.VueColor.Chrome,
	},
	template: `
<div class="input-group color-picker" ref="colorpicker">
	<input type="text" v-bind:name="name" class="form-control" v-model="colorValue" @focus="showPicker()" @input="updateFromInput" />
	<span class="input-group-addon color-picker-container">
		<span class="current-color" :style="'background-color: ' + colorValue" @click="togglePicker()"></span>
		<chrome-picker :value="colors" @input="updateFromPicker" v-if="displayPicker" />
	</span>
</div>`,
	props: ['color', 'name'],
	data() {
		return {
			colors: {
				hex: '#000000',
			},
			colorValue: '',
			displayPicker: false,
		};
	},
	mounted() {
		this.setColor(this.color || '#000000');
	},
	methods: {
		setColor(color) {
			this.updateColors(color);
			this.colorValue = color;
		},
		updateColors(color) {
			if (color.slice(0, 1) == '#') {
				this.colors = {
					hex: color,
				};
			} else if (color.slice(0, 4) == 'rgba') {
				var rgba = color.replace(/^rgba?\(|\s+|\)$/g, '').split(','),
					hex = '#' + ((1 << 24) + (parseInt(rgba[0]) << 16) + (parseInt(rgba[1]) << 8) + parseInt(rgba[2])).toString(16).slice(1);
				this.colors = {
					hex: hex,
					a: rgba[3],
				};
			}
		},
		showPicker() {
			document.addEventListener('click', this.documentClick);
			this.displayPicker = true;
		},
		hidePicker() {
			document.removeEventListener('click', this.documentClick);
			this.displayPicker = false;
		},
		togglePicker() {
			this.displayPicker ? this.hidePicker() : this.showPicker();
		},
		updateFromInput() {
			this.updateColors(this.colorValue);
		},
		updateFromPicker(color) {
			this.colors = color;
			if (color.rgba.a == 1) {
				this.colorValue = color.hex;
			} else {
				this.colorValue = 'rgba(' + color.rgba.r + ', ' + color.rgba.g + ', ' + color.rgba.b + ', ' + color.rgba.a + ')';
			}
		},
		documentClick: function (e) {
			var el = this.$refs.colorpicker,
				target = e.target;
			if (el !== target && !el.contains(target)) {
				this.hidePicker();
			}
		},
	},
	watch: {
		colorValue(val) {
			if (val) {
				this.updateColors(val);
				this.$emit('input', val);
			}
		},
		color(val) {
			if (val) {
				this.colorValue = val;
			}
		},
	},
});

Vue.component('autosized-textarea', {
	methods: {
		resizeTextarea(even) {
			event.target.style.height = 'auto';
			event.target.style.cssText = `height:${event.target.scrollHeight}px!important;overflow-y:hidden!important;min-height:0`;
		},
	},
	mounted: function () {
		this.$nextTick(function () {
			this.$el.setAttribute('style', 'height:' + this.$el.scrollHeight + 'px;overflow-y:hidden;min-height:0');
		});
		this.$el.addEventListener('change', this.resizeTextarea);
	},
	beforeDestroy: function () {
		this.$el.removeEventListener('change', this.resizeTextarea);
	},
	render: function () {
		return this.$slots.default[0];
	},
});

new Vue({
	el: '#buttonGeneratorApp',
	components: {
		'chrome-picker': window.VueColor.Chrome,
	},
	data: {
		buttonText: '',
		fixed: false,
		iconSize: '25',
		helpUrl: '',
		fontSize: '13',
		fontWeightSliderValue: '1',
		fontWeight: '400',
		textColor: '#000000',
		textColorHover: '#000000',
		textUnderline: false,
		textUnderlineHover: false,
		backgroundColor: '#efefef',
		backgroundColorHover: '#ffffff',
		borderWidth: '1',
		borderRadius: '3',
		borderStyle: 'solid',
		borderStyleHover: 'solid',
		borderColor: '#dadada',
		borderColorHover: '#efefef',
		paddingHorizontal: '0',
		paddingVertical: '0',
		defaults: {},
	},
	watch: {
		helpUrl(newVal, oldVal) {
			if (newVal == '') this.helpUrl = '';
		},
		fontWeightSliderValue: function (newVal, oldVal) {
			this.fontWeight = fontWeightValues[newVal];
		},
	},
	beforeMount() {
		for (let propertyName in this.$data) {
			if (propertyName !== 'defaults' && propertyName) this.defaults[propertyName] = this[propertyName];
		}
	},
	mounted() {
		if (tmkData) {
			this.$nextTick(function () {
				for (let propertyName in tmkData) {
					this[propertyName] = tmkData[propertyName];
				}
			});
		}
	},
	methods: {
		setAsButton(e) {
			//e.preventDefault();
			for (let propertyName in buttonStyle) {
				this[propertyName] = buttonStyle[propertyName];
			}
		},
		setAsLink(e) {
			//e.preventDefault();
			for (let propertyName in linkStyle) {
				this[propertyName] = linkStyle[propertyName];
			}
		},
		fontWeightLabel() {
			return fontWeightLabels[this.fontWeightSliderValue];
		},
		getObject() {
			let data = {};
			Object.assign(data, this.$data);
			delete data.defaults;
			delete data.fontWeightSliderValue;
			for (let propertyName in data) {
				if (data[propertyName] === this.defaults[propertyName]) delete data[propertyName];
			}
			for (let propertyName in data) {
				if (intProps.indexOf(propertyName) !== -1) data[propertyName] = parseInt(data[propertyName]);
			}

			for (let propertyName in data) {
				if (boolProps.indexOf(propertyName) !== -1) {
					if (data[propertyName] === 'false' || data[propertyName] === false) {
						data[propertyName] = false;
					} else {
						data[propertyName] = true;
					}
				}
			}

			return data;
		},
		json() {
			const data = this.getObject();
			const iframe = document.querySelector('#preview iframe');
			if (iframe) {
				iframe.contentWindow.postMessage({ styleUpdate: true, styleObject: data }, '*');
			}
			const ref = this.$refs.codeTextarea;
			setTimeout(function () {
				ref && ref.dispatchEvent && ref.dispatchEvent(new Event('change'));
			}, 100);
			return Object.keys(data).length ? JSON.stringify(data, null, 0) : null;
		},
		code() {
			const code = document.createElement('div');
			code.classList.add('tomikup-button');
			this.fixed && code.classList.add('tomikup-fixed');
			const json = this.json();
			json && code.setAttribute('data-json', json);
			this.helpUrl && this.helpUrl.match(urlCheck) && code.setAttribute('data-howItWorks', this.helpUrl);
			return code.outerHTML;
		},
		suggestionChoosen(e) {
			this.buttonText = e.target.textContent;
		},
	},
});
