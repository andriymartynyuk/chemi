/* jshint esversion: 6 */
import PropTypes from 'prop-types';
import classnames from 'classnames';
import ResponsiveControl from '../common/responsive.js';
import Icons from '../common/icons.js';
import { ReactSortable } from "react-sortablejs";
import uniqueId from 'lodash/uniqueId';

import ItemComponent from './item-component';

const { __ } = wp.i18n;

const { ButtonGroup, Dashicon, Tooltip, Popover, Button, SelectControl } = wp.components;

const { Component, Fragment } = wp.element;
class SocialComponent extends Component {
	constructor() {
		super( ...arguments );
		this.updateValues = this.updateValues.bind( this );
		this.onDragEnd = this.onDragEnd.bind( this );
		this.onDragStart = this.onDragStart.bind( this );
		this.onDragStop = this.onDragStop.bind( this );
		this.removeItem = this.removeItem.bind( this );
		this.saveArrayUpdate = this.saveArrayUpdate.bind( this );
		this.toggleEnableItem = this.toggleEnableItem.bind( this );
		this.onChangeIcon = this.onChangeIcon.bind( this );
		this.onChangeLabel = this.onChangeLabel.bind( this );
		this.onChangeURL = this.onChangeURL.bind( this );
		this.onChangeAttachment = this.onChangeAttachment.bind( this );
		this.onChangeWidth = this.onChangeWidth.bind( this );
		this.onChangeSource = this.onChangeSource.bind( this );
		this.addItem = this.addItem.bind( this );
		let value = this.props.control.setting.get();
		let baseDefault = {
			'items': [
				{
					'id': 'facebook',
					'enabled': true,
					'source': 'icon',
					'url': '',
					'imageid': '',
					'width': 24,
					'icon': 'facebook',
					'label': 'Facebook',
				},
				{
					'id': 'twitter',
					'enabled': true,
					'source': 'icon',
					'url': '',
					'imageid': '',
					'width': 24,
					'icon': 'twitter',
					'label': 'Twitter',
				}
			],
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
			'group' : 'social_item_group',
			'options': [
				{ value: 'facebook', label: __( 'Facebook', 'indro' ) },
				{ value: 'twitter', label: __( 'Twitter', 'indro' ) },
				{ value: 'instagram', label: __( 'Instagram', 'indro' ) },
				{ value: 'youtube', label: __( 'YouTube', 'indro' ) },
				{ value: 'facebook_group', label: __( 'Facebook Group', 'indro' ) },
				{ value: 'vimeo', label: __( 'Vimeo', 'indro' ) },
				{ value: 'pinterest', label: __( 'Pinterest', 'indro' ) },
				{ value: 'linkedin', label: __( 'Linkedin', 'indro' ) },
				{ value: 'medium', label: __( 'Medium', 'indro' ) },
				{ value: 'wordpress', label: __( 'WordPress', 'indro' ) },
				{ value: 'reddit', label: __( 'Reddit', 'indro' ) },
				{ value: 'patreon', label: __( 'Patreon', 'indro' ) },
				{ value: 'github', label: __( 'GitHub', 'indro' ) },
				{ value: 'dribbble', label: __( 'Dribbble', 'indro' ) },
				{ value: 'behance', label: __( 'Behance', 'indro' ) },
				{ value: 'vk', label: __( 'VK', 'indro' ) },
				{ value: 'xing', label: __( 'Xing', 'indro' ) },
				{ value: 'rss', label: __( 'RSS', 'indro' ) },
				{ value: 'email', label: __( 'Email', 'indro' ) },
				{ value: 'phone', label: __( 'Phone', 'indro' ) },
				{ value: 'whatsapp', label: __( 'WhatsApp', 'indro' ) },
				{ value: 'google_reviews', label: __( 'Google Reviews', 'indro' ) },
				{ value: 'telegram', label: __( 'Telegram', 'indro' ) },
				{ value: 'yelp', label: __( 'Yelp', 'indro' ) },
				{ value: 'trip_advisor', label: __( 'Trip Advisor', 'indro' ) },
				{ value: 'imdb', label: __( 'IMDB', 'indro' ) },
				{ value: 'soundcloud', label: __( 'SoundCloud', 'indro' ) },
				{ value: 'tumblr', label: __( 'Tumblr', 'indro' ) },
				{ value: 'discord', label: __( 'Discord', 'indro' ) },
				{ value: 'tiktok', label: __( 'TikTok', 'indro' ) },
				{ value: 'spotify', label: __( 'Spotify', 'indro' ) },
				{ value: 'apple_podcasts', label: __( 'Apple Podcast', 'indro' ) },
				{ value: 'flickr', label: __( 'Flickr', 'indro' ) },
				{ value: '500px', label: __( '500PX', 'indro' ) },
				{ value: 'bandcamp', label: __( 'Bandcamp', 'indro' ) },
			],
		};
		this.controlParams = this.props.control.params.input_attrs ? {
			...defaultParams,
			...this.props.control.params.input_attrs,
		} : defaultParams;
		let availibleSocialOptions = [];
		this.controlParams.options.map( ( option ) => {
			if ( ! value.items.some( obj => obj.id === option.value ) ) {
				availibleSocialOptions.push( option );
			}
		} );
		this.state = {
			value: value,
			isVisible: false,
			control: ( undefined !== availibleSocialOptions[0] && undefined !== availibleSocialOptions[0].value ? availibleSocialOptions[0].value : '' ),
		};
	}
	onDragStart() {
		var dropzones = document.querySelectorAll( '.indro-builder-area' );
		var i;
		for (i = 0; i < dropzones.length; ++i) {
			dropzones[i].classList.add( 'indro-dragging-dropzones' );
		}
	}
	onDragStop() {
		var dropzones = document.querySelectorAll( '.indro-builder-area' );
		var i;
		for (i = 0; i < dropzones.length; ++i) {
			dropzones[i].classList.remove( 'indro-dragging-dropzones' );
		}
	}
	saveArrayUpdate( value, index ) {
		let updateState = this.state.value;
		let items = updateState.items;

		const newItems = items.map( ( item, thisIndex ) => {
			if ( index === thisIndex ) {
				item = { ...item, ...value };
			}

			return item;
		} );
		updateState.items = newItems;
		this.setState( { value: updateState } );
		this.updateValues( updateState );
	}
	toggleEnableItem( value, itemIndex ) {
		this.saveArrayUpdate( { enabled: value }, itemIndex );
	}
	onChangeLabel( value, itemIndex ) {
		this.saveArrayUpdate( { label: value }, itemIndex );
	}
	onChangeIcon( value, itemIndex ) {
		this.saveArrayUpdate( { icon: value }, itemIndex );
	}
	onChangeURL( value, itemIndex ) {
		this.saveArrayUpdate( { url: value }, itemIndex );
	}
	onChangeAttachment( value, itemIndex ) {
		this.saveArrayUpdate( { imageid: value }, itemIndex );
	}
	onChangeWidth( value, itemIndex ) {
		this.saveArrayUpdate( { width: value }, itemIndex );
	}
	onChangeSource( value, itemIndex ) {
		this.saveArrayUpdate( { source: value }, itemIndex );
	}
	removeItem( itemIndex ) {
		let updateState = this.state.value;
		let update = updateState.items;
		let updateItems = [];
		{ update.length > 0 && (
			update.map( ( old, index ) => {
				if ( itemIndex !== index ) {
					updateItems.push( old );
				}
			} )
		) };
		updateState.items = updateItems;
		this.setState( { value: updateState } );
		this.updateValues( updateState );
	}
	addItem() {
		const itemControl = this.state.control;
		this.setState( { isVisible: false } );
		if ( itemControl ) {
			let updateState = this.state.value;
			let update = updateState.items;
			const itemLabel = this.controlParams.options.filter(function(o){return o.value === itemControl;} );
			let newItem = {
				'id': itemControl,
				'enabled': true,
				'source': 'icon',
				'url': '',
				'imageid': '',
				'width': 24,
				'icon': itemControl,
				'label': itemLabel[0].label,
			};
			update.push( newItem );
			updateState.items = update;
			let availibleSocialOptions = [];
			this.controlParams.options.map( ( option ) => {
				if ( ! update.some( obj => obj.id === option.value ) ) {
					availibleSocialOptions.push( option );
				}
			} );
			this.setState( { control: ( undefined !== availibleSocialOptions[0] && undefined !== availibleSocialOptions[0].value ? availibleSocialOptions[0].value : '' ) } );
			this.setState( { value: updateState } );
			this.updateValues( updateState );
		}
	}
	onDragEnd( items ) {
		let updateState = this.state.value;
		let update = updateState.items;
		let updateItems = [];
		{ items.length > 0 && (
			items.map( ( item ) => {
				update.filter( obj => {
					if ( obj.id === item.id ) {
						updateItems.push( obj );
					}
				} )
			} )
		) };
		if ( ! this.arraysEqual( update, updateItems ) ) {
			update.items = updateItems;
			updateState.items = updateItems;
			this.setState( { value: updateState } );
			this.updateValues( updateState );
		}
	}
	arraysEqual( a, b ) {
		if (a === b) return true;
		if (a == null || b == null) return false;
		if (a.length != b.length) return false;		
		for (var i = 0; i < a.length; ++i) {
			if (a[i] !== b[i]) return false;
		}
		return true;
	}
	render() {
		const currentList = ( typeof this.state.value != "undefined" && this.state.value.items != null && this.state.value.items.length != null && this.state.value.items.length > 0 ? this.state.value.items : [] );
		let theItems = [];
		{ currentList.length > 0 && (
			currentList.map( ( item ) => {
				theItems.push(
					{
						id: item.id,
					}
				)
			} )
		) };
		const availibleSocialOptions = [];
		this.controlParams.options.map( ( option ) => {
			if ( ! theItems.some( obj => obj.id === option.value ) ) {
				availibleSocialOptions.push( option );
			}
		} )
		const toggleClose = () => {
			if ( this.state.isVisible === true ) {
				this.setState( { isVisible: false } );
			}
		};
		return (
			<div className="indro-control-field indro-sorter-items">
				<div className="indro-sorter-row">
					<ReactSortable animation={100} onStart={ () => this.onDragStop() } onEnd={ () => this.onDragStop() } group={ this.controlParams.group } className={ `indro-sorter-drop indro-sorter-sortable-panel indro-sorter-drop-${ this.controlParams.group }` } handle={ '.indro-sorter-item-panel-header' } list={ theItems } setList={ ( newState ) => this.onDragEnd( newState ) } >
						{ currentList.length > 0 && (
							currentList.map( ( item, index ) => {
								return <ItemComponent removeItem={ ( remove ) => this.removeItem( remove ) } toggleEnabled={ ( enable, itemIndex ) => this.toggleEnableItem( enable, itemIndex ) } onChangeLabel={ ( label, itemIndex ) => this.onChangeLabel( label, itemIndex ) } onChangeSource={ ( source, itemIndex ) => this.onChangeSource( source, itemIndex ) } onChangeWidth={ ( width, itemIndex ) => this.onChangeWidth( width, itemIndex ) } onChangeURL={ ( url, itemIndex ) => this.onChangeURL( url, itemIndex ) } onChangeAttachment={ ( imageid, itemIndex ) => this.onChangeAttachment( imageid, itemIndex ) } onChangeIcon={ ( icon, itemIndex ) => this.onChangeIcon( icon, itemIndex ) } key={ item.id } index={ index } item={ item } controlParams={ this.controlParams } />;
							} )
						) }
					</ReactSortable>
				</div>
				{ undefined !== availibleSocialOptions[0] && undefined !== availibleSocialOptions[0].value && (
					<div className="indro-social-add-area">
						{/* <SelectControl
							value={ this.state.control }
							options={ availibleSocialOptions }
							onChange={ value => {
								this.setState( { control: value } );
							} }
						/> */}
						{ this.state.isVisible && (
							<Popover position="top right" className="indro-popover-color indro-popover-social" onClose={ toggleClose }>
								<div className="indro-popover-social-list">
									<ButtonGroup className="indro-radio-container-control">
										{ availibleSocialOptions.map( ( item, index ) => {
											return (
												<Fragment>
													<Button
														isTertiary
														className={ 'social-radio-btn' }
														onClick={ () => {
															this.setState( { control: availibleSocialOptions[index].value } );
															this.state.control = availibleSocialOptions[index].value;
															this.addItem();
														} }
													>
														{ availibleSocialOptions[index].label && (
															availibleSocialOptions[index].label
														) }
													</Button>
												</Fragment>
											);
										} ) }
									</ButtonGroup>
								</div>
							</Popover>
						) }
						<Button
							className="indro-sorter-add-item"
							isPrimary
							onClick={ () => {
								this.setState( { isVisible: true } );
							} }
						>
							{ __( 'Add Social', 'indro' ) }
							<Dashicon icon="plus"/>
						</Button>
						{/* <Button
							className="indro-sorter-add-item"
							isPrimary
							onClick={ () => {
								this.addItem();
							} }
						>
							{ __( 'Add Item', 'indro' ) }
							<Dashicon icon="plus"/>
						</Button> */}
					</div>
				) }
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

SocialComponent.propTypes = {
	control: PropTypes.object.isRequired,
};

export default SocialComponent;
