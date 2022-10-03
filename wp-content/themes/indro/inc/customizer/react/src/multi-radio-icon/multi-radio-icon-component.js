/* jshint esversion: 6 */
import PropTypes from 'prop-types';
import classnames from 'classnames';

import ResponsiveControl from '../common/responsive.js';
import Icons from '../common/icons.js';

const { __ } = wp.i18n;

const { ButtonGroup, Dashicon, Tooltip, Button } = wp.components;

const { Component, Fragment } = wp.element;
class RadioIconComponent extends Component {
	constructor() {
		super( ...arguments );
		this.updateValues = this.updateValues.bind( this );
		let value = this.props.control.setting.get();
		let baseDefault = {
			'include': {
				'mobile': '',
				'tablet': '',
				'desktop': 'logo_title_tagline'
			},
			'layout': {
				'mobile': '',
				'tablet': '',
				'desktop': 'standard'
			}
		};
		this.defaultValue = this.props.control.params.default ? {
			...baseDefault,
			...this.props.control.params.default
		} : baseDefault;
		value = value ? {
			...this.defaultValue,
			...value
		} : this.defaultValue;
		let defaultParams = {
			include: {
				logo_only: {
					tooltip: __( 'Logo Only', 'indro' ),
					name: __( 'Logo', 'indro' ),
				},
				logo_title: {
					tooltip: __( 'Logo & Title', 'indro' ),
					name: __( 'Logo & Title', 'indro' ),
				},
				logo_title_tagline: {
					tooltip: __( 'Logo, Title & Tagline', 'indro' ),
					name: __( 'Logo, Title & Tagline', 'indro' ),
				},
			},
			layout: {
				logo_only: {
					standard: {
						tooltip: __( 'Logo Only', 'indro' ),
						icon: Icons.logo
					},
				},
				logo_title: {
					standard: {
						tooltip: __( 'Logo - Title', 'indro' ),
						icon: Icons.logoTitle
					},
					title_logo: {
						tooltip: __( 'Title - Logo', 'indro' ),
						icon: Icons.titleLogo
					},
					top_logo_title: {
						tooltip: __( 'Top Logo - Title', 'indro' ),
						icon: Icons.topLogoTitle
					},
					top_title_logo: {
						tooltip: __( 'Top Title - Logo', 'indro' ),
						icon: Icons.topTitleLogo
					},
				},
				logo_title_tagline: {
					standard: {
						tooltip: __( 'Logo - Title - Tagline', 'indro' ),
						icon: Icons.logoTitleTag
					},
					title_tag_logo: {
						tooltip: __( 'Title - Tagline - Logo', 'indro' ),
						icon: Icons.titleTagLogo
					},
					top_logo_title_tag: {
						tooltip: __( 'Top Logo - Title - Tagline', 'indro' ),
						icon: Icons.topLogoTitleTag
					},
					top_title_tag_logo: {
						tooltip: __( 'Top Title - Tagline - Logo', 'indro' ),
						icon: Icons.topTitleTagLogo
					},
					top_title_logo_tag: {
						tooltip: __( 'Top Title - Logo - Tagline', 'indro' ),
						icon: Icons.topTitleLogoTag
					}
				},
			}
		};
		this.controlParams = this.props.control.params.input_attrs ? {
			...defaultParams,
			...this.props.control.params.input_attrs,
		} : defaultParams;
		this.state = {
			currentDevice: 'desktop',
			include: value.include,
			layout: value.layout,
		};
	}
	render() {
		const controlLabel = (
			<Fragment>
				{ this.state.currentDevice !== 'desktop' && (
					<Tooltip text={ __( 'Reset Device Values', 'indro' ) }>
						<Button
							className="reset indro-reset"
							disabled={ ( this.state.include[this.state.currentDevice] === this.defaultValue.include[this.state.currentDevice] ) && ( this.state.layout[this.state.currentDevice] === this.defaultValue.layout[this.state.currentDevice] ) }
							onClick={ () => {
								let value = this.state.include;
								value[this.state.currentDevice] = this.defaultValue.include[this.state.currentDevice];
								let svalue = this.state.layout;
								svalue[this.state.currentDevice] = this.defaultValue.layout[this.state.currentDevice];
								this.setState( { include: value, layout: svalue } );
								this.updateValues( { include: value, layout: svalue } );
							} }
						>
							<Dashicon icon='image-rotate' />
						</Button>
					</Tooltip>
				) }
				{ this.props.control.params.label &&
					this.props.control.params.label
				}
			</Fragment>
		);
		return (
			<div className="indro-control-field indro-radio-icon-control">
				<ResponsiveControl
					onChange={ ( currentDevice) => this.setState( { currentDevice } ) }
					controlLabel={ controlLabel }
				>
					<ButtonGroup className="indro-radio-container-control">
						{ Object.keys( this.controlParams.include ).map( ( item ) => {
							return (
								<Tooltip text={ this.controlParams.include[ item ].tooltip }>
									<Button
											isTertiary
											className={ ( item === this.state.include[this.state.currentDevice] ?
													'active-radio ' :
													'' ) + item }
											onClick={ () => {
												let value = this.state.include;
												value[ this.state.currentDevice ] = item;
												let svalue = this.state.layout;
												svalue[ this.state.currentDevice ] = 'standard';
												this.setState( { include: value, layout: svalue } );
												this.updateValues( { include: value, layout: svalue } );
											} }
									>
										{ this.controlParams.include[ item ].name }
									</Button>
								</Tooltip>
							);
						} )}
					</ButtonGroup>
					{ undefined !== this.state.include[this.state.currentDevice] && '' !== this.state.include[this.state.currentDevice] && 'logo_only' !== this.state.include[this.state.currentDevice] && (
						<ButtonGroup className="indro-radio-container-control indro-radio-icon-container-control">
							{ Object.keys( this.controlParams.layout[this.state.include[this.state.currentDevice] ] ).map( ( item ) => {
								return (
									<Tooltip text={ this.controlParams.layout[this.state.include[this.state.currentDevice] ][ item ].tooltip }>
										<Button
												isTertiary
												className={ ( item === this.state.layout[this.state.currentDevice] ?
														'active-radio ' :
														'' ) + item }
												onClick={ () => {
													let value = this.state.layout;
													value[ this.state.currentDevice ] = item;
													this.setState( { layout: value } );
													this.updateValues( { layout: value } );
												} }
										>
											{ this.controlParams.layout[this.state.include[this.state.currentDevice] ][ item ].icon }
										</Button>
									</Tooltip>
								);
							} )}
						</ButtonGroup>
					) }
				</ResponsiveControl>
			</div>
		);
	}

	updateValues( value ) {
		this.props.control.setting.set( {
			...this.props.control.setting.get(),
			...value,
			flag: !this.props.control.setting.get().flag
		} );
	}
}

RadioIconComponent.propTypes = {
	control: PropTypes.object.isRequired
};

export default RadioIconComponent;
