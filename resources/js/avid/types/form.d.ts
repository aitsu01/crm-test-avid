import { ConditionNode } from './condition';

export interface Field {
    name: string;
    label?: string;
    required?: boolean;
    disabled?: boolean;
    readonly?: boolean;
    error?: string;
}

export interface HasPlaceholder {
    placeholder?: string;
}

export interface HasSize {
    size?: 'small' | 'large';
}

export interface HasMin {
    min?: number;
}

export interface HasMax {
    max?: number;
}

export interface HasPrefix {
    prefix?: string;
}

export interface HasSuffix {
    suffix?: string;
}

export interface HasInline {
    inline?: boolean;
}

export interface HasStep {
    step?: number;
}

export interface HasRange {
    range?: boolean;
}

export interface HasMultiple {
    multiple?: boolean;
}

export interface HasOrientation {
    orientation?: 'horizontal' | 'vertical';
}

export interface Option {
    key: any;
    label: string;
    color?: string;
    icon?: string;
    payload: any;
    labelTemplate?: string;
    children?: Option[];
}

export interface HasOptions {
    options?: Option[];
}

export interface HasOptionLabel {
    optionLabel?: string;
}

export interface HasOptionValue {
    optionValue?: string;
}

export interface HasMinDate {
    minDate?: string;
}

export interface HasMaxDate {
    maxDate?: string;
}

export interface HasHeader {
    header?: string;
    isHeaderRaw?: boolean;
}

export interface HasFooter {
    footer?: string;
    isFooterRaw?: boolean;
}

export interface HasVirtualScroll {
    virtualScroll?: number;
}

export interface HasClearable {
    clearable?: boolean;
}

export interface HasAsync {
    async?: string;
    params?: any;
}

export interface HasFilter {
    filter?: boolean;
    filterPlaceholder?: string;
}

export interface HasTemplateOption {
    templateOption?: boolean;
}

export interface HasFile {
    accept?: string;
    maxFileSize?: number;
}

export interface CanCreateRecord {
    createRecordUrl?: string;
    createRecordLabel?: string;
}

export interface CanBeTranslated {
    defaultLocale?: string;
    locales?: Option[];
}

export interface CanBeTranslated {
    defaultLocale?: string;
    locales?: Option[];
}

export interface Schema {
    component: string;
    type: 'layout' | 'field';
    props: any;
    conditions: {
        hidden?: ConditionNode;
        visible?: ConditionNode;
        disabled?: ConditionNode;
        readonly?: ConditionNode;
        required?: ConditionNode;
    };
    children?: Schema[];
}

export interface Form {
    method: 'post' | 'put';
    submit?: string;
    cancel?: string;
    schema: Schema[];
    defaultData: any;
    buttonsPosition?: 'start' | 'center' | 'end' | 'hidden';
}
