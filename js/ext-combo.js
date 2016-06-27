/*
	JavaScript ini digunakan untuk overide method setValue pada combo box Ext JS
*/
Ext.override(Ext.form.ComboBox, {
    setValue : function(v){
        var text = v;
        if(this.valueField){
            if((this.mode == 'local' || this.mode == 'remote') && !Ext.isDefined(this.store.totalLength)){
                this.store.on('load', this.setValue.createDelegate(this, arguments), null, {single: true});
                if(this.store.lastOptions === null){
                    var params = {};
                    if(this.valueParam){
                        params[this.valueParam] = v;
                    }else{
                        params[this.queryParam] = this.allQuery;
                    }
                    this.store.load({params: params});
                }
                return;
            }
            var r = this.findRecord(this.valueField, v);
            if(r){
                text = r.data[this.displayField];
            }else if(this.valueNotFoundText !== undefined){
                text = this.valueNotFoundText;
            }
        }
        this.lastSelectionText = text;
        if(this.hiddenField){
            this.hiddenField.value = v;
        }
        Ext.form.ComboBox.superclass.setValue.call(this, text);
        this.value = v;
    }
});