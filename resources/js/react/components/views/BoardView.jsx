import React, { useState } from 'react';
import { DragDropContext, Droppable, Draggable } from '@hello-pangea/dnd';
import { Plus, MoreHorizontal, Calendar, GripVertical } from 'lucide-react';
import { format } from 'date-fns';

const MOCK_DATA = {
    'todo': { id: 'todo', title: 'Not Started', taskIds: ['t1', 't2'] },
    'in_progress': { id: 'in_progress', title: 'In Progress', taskIds: ['t3'] },
    'done': { id: 'done', title: 'Completed', taskIds: [] },
};

const MOCK_TASKS = {
    't1': { id: 't1', title: 'Research competitors', priority: 'High', date: new Date() },
    't2': { id: 't2', title: 'Design landing page', priority: 'Medium', date: null },
    't3': { id: 't3', title: 'Implement auth', priority: 'Urgent', date: new Date() },
};

export default function BoardView() {
    const [data, setData] = useState(MOCK_DATA);
    const [tasks, setTasks] = useState(MOCK_TASKS);

    const onDragEnd = (result) => {
        const { destination, source, draggableId } = result;
        if (!destination) return;
        if (destination.droppableId === source.droppableId && destination.index === source.index) return;

        const sourceCol = data[source.droppableId];
        const destCol = data[destination.droppableId];

        if (sourceCol.id === destCol.id) {
            const newTaskIds = Array.from(sourceCol.taskIds);
            newTaskIds.splice(source.index, 1);
            newTaskIds.splice(destination.index, 0, draggableId);

            const newCol = { ...sourceCol, taskIds: newTaskIds };
            setData((prev) => ({ ...prev, [newCol.id]: newCol }));
            return;
        }

        const startTaskIds = Array.from(sourceCol.taskIds);
        startTaskIds.splice(source.index, 1);
        const newStart = { ...sourceCol, taskIds: startTaskIds };

        const finishTaskIds = Array.from(destCol.taskIds);
        finishTaskIds.splice(destination.index, 0, draggableId);
        const newFinish = { ...destCol, taskIds: finishTaskIds };

        setData((prev) => ({
            ...prev,
            [newStart.id]: newStart,
            [newFinish.id]: newFinish,
        }));
    };

    return (
        <div className="flex h-full w-full gap-6 overflow-x-auto p-2 pb-6">
            <DragDropContext onDragEnd={onDragEnd}>
                {Object.values(data).map((column) => (
                    <div key={column.id} className="flex min-w-[300px] max-w-[300px] flex-col rounded-xl bg-surface-100 p-3 dark:bg-dark-surface2/50">
                        <div className="mb-4 flex items-center justify-between px-1">
                            <h3 className="flex items-center gap-2 text-sm font-semibold">
                                {column.title}
                                <span className="flex h-5 w-5 items-center justify-center rounded-full bg-surface-300 text-xs text-text-muted dark:bg-dark-border dark:text-text-darkMuted">
                                    {column.taskIds.length}
                                </span>
                            </h3>
                            <div className="flex items-center gap-1">
                                <button className="rounded p-1 text-text-muted hover:bg-surface-200 dark:hover:bg-dark-surface"><Plus size={14} /></button>
                                <button className="rounded p-1 text-text-muted hover:bg-surface-200 dark:hover:bg-dark-surface"><MoreHorizontal size={14} /></button>
                            </div>
                        </div>

                        <Droppable droppableId={column.id}>
                            {(provided, snapshot) => (
                                <div
                                    ref={provided.innerRef}
                                    {...provided.droppableProps}
                                    className={`flex-1 space-y-3 transition-colors ${snapshot.isDraggingOver ? 'bg-surface-200/50 dark:bg-dark-surface' : ''} rounded-lg p-1`}
                                >
                                    {column.taskIds.map((taskId, index) => {
                                        const task = tasks[taskId];
                                        return (
                                            <Draggable key={task.id} draggableId={task.id} index={index}>
                                                {(provided, snapshot) => (
                                                    <div
                                                        ref={provided.innerRef}
                                                        {...provided.draggableProps}
                                                        {...provided.dragHandleProps}
                                                        className={`group relative rounded-xl border border-surface-200 bg-white p-4 shadow-sm transition-shadow hover:shadow-md dark:border-dark-border dark:bg-dark-surface ${
                                                            snapshot.isDragging ? 'shadow-xl ring-2 ring-primary' : ''
                                                        }`}
                                                    >
                                                        <div className="mb-3 flex items-start justify-between gap-2">
                                                            <p className="text-sm font-medium leading-snug">{task.title}</p>
                                                            <div className="opacity-0 transition-opacity group-hover:opacity-100">
                                                                <GripVertical size={14} className="text-surface-400" />
                                                            </div>
                                                        </div>
                                                        <div className="flex flex-wrap items-center gap-2">
                                                            <span className="rounded bg-orange-100 px-2 py-0.5 text-[10px] font-semibold text-orange-700 dark:bg-orange-500/20 dark:text-orange-400">
                                                                {task.priority}
                                                            </span>
                                                            {task.date && (
                                                                <span className="flex items-center gap-1 text-[11px] font-medium text-text-muted dark:text-text-darkMuted">
                                                                    <Calendar size={12} />
                                                                    {format(task.date, 'MMM d')}
                                                                </span>
                                                            )}
                                                        </div>
                                                    </div>
                                                )}
                                            </Draggable>
                                        );
                                    })}
                                    {provided.placeholder}
                                    <button className="flex w-full items-center gap-2 rounded-lg p-2 text-sm text-text-muted transition-colors hover:bg-surface-200 dark:text-text-darkMuted dark:hover:bg-dark-surface">
                                        <Plus size={16} /> New
                                    </button>
                                </div>
                            )}
                        </Droppable>
                    </div>
                ))}
            </DragDropContext>
            
            {/* Add Column Button */}
            <button className="flex min-w-[280px] items-center gap-2 rounded-xl border border-dashed border-surface-300 p-4 text-sm font-medium text-text-muted transition-colors hover:border-primary hover:bg-primary/5 hover:text-primary dark:border-dark-border dark:text-text-darkMuted dark:hover:border-primary">
                <Plus size={16} /> Add Group
            </button>
        </div>
    );
}
