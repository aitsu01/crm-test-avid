// Rappresenta una singola condizione (nodo "foglia" dell'albero)
export interface SimpleCondition {
    type: 'condition';
    field: string;
    operator: string;
    value: any;
}

// Rappresenta un gruppo di condizioni (nodo "ramo" dell'albero)
export interface GroupCondition {
    type: 'group';
    operator: 'AND' | 'OR';
    children: ConditionNode[]; // Un gruppo contiene altri nodi
}

// Un nodo può essere o un gruppo o una condizione semplice
export type ConditionNode = GroupCondition | SimpleCondition;
