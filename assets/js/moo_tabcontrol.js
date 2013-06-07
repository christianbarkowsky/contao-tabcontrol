/**
 * TabControl creates tabs for defined contents.
 * 
 * As of v1.2 of TabControl, initial tab can be specified via URIs anchor,
 * thus improving barrierfreeness. Note that specifying an initialTab-parameter
 * always overrides this behaviour!
 *
 * @uses MooTools v1.2
 * @version 1.2
 * @license MIT-style license
 * @author Jean-Bernard Valentaten - <troggy [dot] brains [at] gmx [dot] de>
 * @author Mirco Rahn - <m [dot] rahn [at] complus-ag [dot] de> 
 * 
 * @copyright Author
 */
 
(function($) {

//create class
//TC = new Array();
//TabControl = new Class();

/**
 * Options:
 *
 * Name          | Type      | Description
 * --------------+-----------+---------------------------------------------------------------------
 * behaviour     | String    | Defines whether the panes shall be shown on 'click' (default) or 'mouseover'
 * hoverClass    | String    | The css-class that will be assigned to a tab when being hovered, if behaviour is set to 'click' (defaults to empty string)
 * initialTab    | String    | The id of the tab that will be selected on initialization (defaults to first tab)
 * onChange      | Callback  | Fired whenever the tab is changed. Passes the currently visible pane and selected tab
 * panes         | Array     | The (ids of the) panes in the correct order. If missing will use css-rule div#pane<N> within element
 * selectedClass | String    | The css-class that will be assigned to the selected tab (defaults to empty string)
 * tabs          | Array     | The (ids of the) tabs in the correct order. If missing will use css-rule div#tab<N> within element
 */
var TabControl = new Class({
    Implements: Options,
    /**
     * Constructor
     *
     * @param {Element,String} element The element that will be used as container for the tab-control
     * @param {Object} [options] The options as seen above
     */
    options: {
        behaviour: 'click',
        hoverClass: '',
        initialTab: '',
        onChange: function(){},
        selectedClass: '',
        autoSlide: false,
        delay: 5000,
        bgOverlayTab: '',
        bgOverlayCss: '',
        addFade: false,
        defaultTab: ''
    },
    
    initialize: function(element, options) {
        //init vars
        //var tabcontrol = this;
        //console.log('TabControl.init');
        //init datamembers
        this.setOptions(options);
        this.element = $(element);
        this.panes = new Array();
        this.tabs = new Array();
        
        //grab optional datamembers
        this.behaviour = this.options.behaviour;
        this.hoverClass = this.options.hoverClass;
        this.initialTab = this.options.initialTab;
        this.onChange = this.options.onChange;
        this.selectedClass = this.options.selectedClass;
        this.bgOverlayTab = this.options.bgOverlayTab;
        this.bgOverlayCss = this.options.bgOverlayCss;
        this.addFade = this.options.addFade;
        this.defaultTab = this.options.defaultTab;
        
        //init tabs and panes
        this._initTabs();
        this._initPanes();
        
        // for Autoplay
        this.maxIndex = 0;
        this.currentIndex= 0;

        //redefault initial tab if needed and have it displayed
        if (!this.initialTab) {
            //init local vars
            var anchoredPane = $(location.hash.substr(1));
            var initialIndex = (this.defaultTab) ? this.defaultTab : 0;
            
            //check whether URIs anchor can be found in our panes
            if (anchoredPane) this.panes.each(function(pane, index) {
                if (anchoredPane === pane) initialIndex = index;
            }); 
            
            //and apply what we have computed
            this.initialTab = this.tabs[initialIndex];
        }
        this.selectTab(null, this.initialTab);
        if(this.options.autoSlide){
            this.addControl();
        }
    },
    
    /**
     * Destructor
     */
    dispose: function() {},
    
    /*
     * Private methods
     */
    
    /**
     * Grabs the panes
     * 
     * @private
     */
    _initPanes: function() {
        //init vars
        var panes = this.options.panes || new Array();
        
        //if we don't have panes, we try to grab 'em
        if (!panes.length) {
            this.element.getElements('div').each(function(el) {
                if (el.id && el.id.search(/^pane(\d+)$/)==0) {
                    panes.push(el);
                }
            });
        }
        
        //iterate through panes adding them to our 
        //panes-datamember
        panes.each(function(s) {
            this.panes.push($(s));
        }, this);
    },
    
    /**
     * Grabs the tabs and installs listeners
     * 
     * @private
     */
    _initTabs: function() {
        //init vars
        var tabs = this.options.tabs || new Array();
        
        //if we don't have tabs, we try to grab 'em
        if (!tabs.length) {
            this.element.getElements('div').each(function(el) {
                if (el.id && el.id.search(/^tab(\d+)$/)==0) {
                    tabs.push(el);
                }
            });
        }
        
        //iterate through tabs adding them to our 
        //tabs-datamember and setting up listeners
        tabs.each(function(s) {
            var elem = $(s);
            var self = this;
            //add an eventlistener
            elem.addEvent(this.behaviour, function() {

                self.selectTab(this, elem);
            });
            
            //if we're not in 'mouseover'-mode and hoverClass is set, we add a listener for hovering
            if (this.behaviour!='mouseover') {
                elem.addEvent('mouseover', this.highlightTab.bind(this, elem));
                elem.addEvent('mouseout', this.unHighlightTab.bind(this, elem));
            }
            this.tabs.push(elem);
        }, this);
    },
    
    /*
     * Public methods
     */
    
    /**
     * Returns the index of the specified tab
     * 
     * @param {String,Element} tab The tab whose index shall be returned
     * @return {int} The index of the specified tab if tab is valid, -1 otherwise
     */
    getTabIndex: function(tab) {
        //return the index of specified tab
        return this.tabs.indexOf($(tab));
    },
    
    /**
     * Hightlights currently hovered tab by adding hoverClass to it
     * and removes hoverClass from all others.
     * 
     * @param {String,Element} tab The tab where mousecursor is curretly over 
     */
    highlightTab: function(tab) {
        //if no hoverClass is defined, we terminate
        
        if (!this.hoverClass) return;
        
        //if tab does not have hoverClass, we add it
        if (!tab.hasClass(this.hoverClass)) tab.addClass(this.hoverClass);
    },
    
    /**
     * Will select specified tab and show its associated pane.
     *
     * @param {Event} evt The event that fired this function (can be null if used from external script)
     * @param {Element} tab The tab for which a pane shall be shown
     */
    selectTab: function(evt, tab) {
        //init vars
        var currentPane;
        var currentTab;


        
        //make sure tab is extended
        tab = $(tab);
        
        //iterate through tabs, showing/hiding the associated panes
        this.tabs.each(function(s, n) {
            if (s===tab) {
                s.addClass(this.selectedClass);
                
                if(this.addFade)
                {
	                if (this.panes[n]) this.panes[n].setStyle('display', 'block').fade('in');
                }
                else
                {
	                if (this.panes[n]) this.panes[n].setStyle('display', 'block');
                }
                
                currentPane = this.panes[n];
                currentTab    = s;
                if(this.bgOverlayTab) {$(this.bgOverlayTab).addClass(this.bgOverlayCss + n);}
                this.currentIndex = n;
            } else {
                s.removeClass(this.selectedClass);
                
                if(this.addFade)
                {
	                if (this.panes[n]) this.panes[n].fade('out').setStyle('display', 'none');
                }
                else
                {
	                if (this.panes[n]) this.panes[n].setStyle('display', 'none');
                }
                                
                if(this.bgOverlayTab) {$(this.bgOverlayTab).removeClass(this.bgOverlayCss + n);}
            }
        }, this);
        
        //finally, we call the onChange-callback
        this.onChange(currentPane, currentTab);
    },
    
    /**
     * Selects a tab by its index and shows its associated pane.
     * If index is not valid and force is not set, terminates 
     * without any change. If index is not valid and force is 
     * set, displays either first or last tab, depending on which 
     * bound is nearer to index (e.g. with index set to -1, first
     * tab ist selected)
     * 
     * @param {int} index The index of the tab that shall be selected
     * @param {bool} [force] Force a tab to be selected even if index is not valid (defaults to false) 
     */
    selectTabByIndex: function(index, force) {
        //do we have to force an action
        if (index<0 && force) {
            index = 0
        } else if (this.tabs.length<=index && force) {
            index = this.tabs.length-1;
        } else if (index<0 || index>=this.tabs.length) {
            return;
        }
        
        //select that tab and off we go
        this.selectTab(null, this.tabs[index]);
    },
    
    unHighlightTab: function(tab) {
        //if no hoverClass is defined, we terminate
        if (!this.hoverClass) return;
        
        //if tab does have hoverClass, we remove it
        if (tab.hasClass(this.hoverClass)) tab.removeClass(this.hoverClass);
    },
    
    // new Autoplay ...
    skipNext: function(option){
        this.currentIndex += 1;
        if(this.currentIndex >= this.tabs.length){
            this.currentIndex = 0;
        }
        this.selectTabByIndex(this.currentIndex);
    },

    pauseSlide: function(){
        clearInterval(this.autoSlide);
    },
    continueSlide: function(){
        this.autoSlide = this.skipNext.periodical(this.options.delay, this);
    },
    
    addControl: function(){
        if(this.tabs != undefined){
            this.tabs.each(function(s) {
                var elem = $(s);
                elem.addEvent('mouseover', this.pauseSlide.bind(this, elem));
                elem.addEvent('mouseout', this.continueSlide.bind(this, elem));
            }, this);
        }
        this.autoSlide = this.skipNext.periodical(this.options.delay, this);
    }
    
});

window.TabControl = TabControl;

})(document.id);
