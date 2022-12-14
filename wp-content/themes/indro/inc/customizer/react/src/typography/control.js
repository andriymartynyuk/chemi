import TypographyComponent from './typography-component.js';

export const TypographyControl = wp.customize.indroControl.extend( {
	renderContent: function renderContent() {
		let control = this;
		ReactDOM.render(
				<TypographyComponent control={control} customizer={ wp.customize }/>,
				control.container[0]
		);
	}
} );
