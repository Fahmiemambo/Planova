import React from 'react';
import useTaskStore from './store/useTaskStore';
import CommandMenu from './components/CommandMenu';
import TableView from './components/views/TableView';
import BoardView from './components/views/BoardView';
import { Search } from 'lucide-react';

export default function App() {
    const { currentView, setView } = useTaskStore();

    return (
        <div className="flex h-full flex-col">
            {/* Top Toolbar */}
            <div className="flex items-center justify-between border-b border-surface-200 p-3 dark:border-dark-border">
                <div className="flex space-x-1">
                    {['table', 'board', 'calendar'].map((view) => (
                        <button
                            key={view}
                            onClick={() => setView(view)}
                            className={`rounded-md px-3 py-1.5 text-sm font-medium transition-colors ${
                                currentView === view
                                    ? 'bg-surface-200 text-text-main shadow-sm dark:bg-dark-surface2 dark:text-text-darkMain'
                                    : 'text-text-muted hover:bg-surface-100 dark:text-text-darkMuted dark:hover:bg-dark-surface2/50'
                            }`}
                        >
                            {view.charAt(0).toUpperCase() + view.slice(1)}
                        </button>
                    ))}
                </div>
                
                <div className="flex items-center gap-2">
                    <button 
                        onClick={() => document.dispatchEvent(new KeyboardEvent('keydown', { key: 'k', metaKey: true }))}
                        className="flex items-center gap-2 rounded-lg border border-surface-200 bg-surface-50 px-3 py-1.5 text-xs font-medium text-text-muted transition-colors hover:bg-surface-100 dark:border-dark-border dark:bg-dark-surface dark:text-text-darkMuted dark:hover:bg-dark-surface2"
                    >
                        <Search size={14} />
                        <span>Search...</span>
                        <kbd className="rounded bg-surface-200 px-1 font-sans text-[10px] dark:bg-dark-border">⌘K</kbd>
                    </button>
                </div>
            </div>

            {/* View Content */}
            <div className="flex-1 overflow-auto">
                {currentView === 'table' && <TableView />}
                {currentView === 'board' && <BoardView />}
                {currentView === 'calendar' && (
                    <div className="flex h-full items-center justify-center text-text-muted">
                        Calendar View (WIP)
                    </div>
                )}
            </div>

            <CommandMenu />
        </div>
    );
}
