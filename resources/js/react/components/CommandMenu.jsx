import React, { useEffect, useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Search, Plus, Settings, Archive, Moon, Sun, Monitor } from 'lucide-react';
import useTaskStore from '../store/useTaskStore';

export default function CommandMenu() {
    const [isOpen, setIsOpen] = useState(false);
    const { searchQuery, setSearchQuery, setView } = useTaskStore();

    useEffect(() => {
        const handleKeyDown = (e) => {
            if (e.key === 'k' && (e.metaKey || e.ctrlKey)) {
                e.preventDefault();
                setIsOpen((prev) => !prev);
            }
            if (e.key === 'Escape') {
                setIsOpen(false);
            }
        };

        window.addEventListener('keydown', handleKeyDown);
        return () => window.removeEventListener('keydown', handleKeyDown);
    }, []);

    const commands = [
        { icon: <Plus size={16} />, label: 'Create new task', action: () => { setIsOpen(false); /* open create modal */ } },
        { icon: <Search size={16} />, label: 'Search tasks...', action: () => { document.getElementById('global-search')?.focus(); setIsOpen(false); } },
        { icon: <Settings size={16} />, label: 'Settings', action: () => setIsOpen(false) },
        { icon: <Moon size={16} />, label: 'Dark mode', action: () => { document.documentElement.classList.add('dark'); setIsOpen(false); } },
        { icon: <Sun size={16} />, label: 'Light mode', action: () => { document.documentElement.classList.remove('dark'); setIsOpen(false); } },
        { icon: <Archive size={16} />, label: 'View Archive', action: () => setIsOpen(false) },
    ];

    return (
        <AnimatePresence>
            {isOpen && (
                <>
                    <motion.div
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                        className="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm"
                        onClick={() => setIsOpen(false)}
                    />
                    <motion.div
                        initial={{ opacity: 0, scale: 0.95, y: -20 }}
                        animate={{ opacity: 1, scale: 1, y: 0 }}
                        exit={{ opacity: 0, scale: 0.95, y: -20 }}
                        transition={{ duration: 0.15, ease: 'easeOut' }}
                        className="fixed left-1/2 top-[15%] z-50 w-full max-w-lg -translate-x-1/2 overflow-hidden rounded-xl border border-surface-200 bg-white shadow-2xl dark:border-dark-border dark:bg-dark-surface"
                    >
                        <div className="flex items-center border-b border-surface-200 px-4 py-3 dark:border-dark-border">
                            <Search className="mr-3 text-text-muted dark:text-text-darkMuted" size={18} />
                            <input
                                type="text"
                                placeholder="Type a command or search..."
                                className="w-full bg-transparent text-sm text-text-main outline-none placeholder:text-text-muted dark:text-text-darkMain dark:placeholder:text-text-darkMuted"
                                autoFocus
                                value={searchQuery}
                                onChange={(e) => setSearchQuery(e.target.value)}
                            />
                            <div className="rounded border border-surface-200 bg-surface-100 px-1.5 py-0.5 text-[10px] font-medium text-text-muted dark:border-dark-border dark:bg-dark-surface2 dark:text-text-darkMuted">
                                ESC
                            </div>
                        </div>
                        <div className="max-h-72 overflow-y-auto p-2">
                            <div className="mb-2 px-2 text-xs font-semibold text-text-muted dark:text-text-darkMuted">
                                Suggestions
                            </div>
                            {commands.map((cmd, idx) => (
                                <button
                                    key={idx}
                                    onClick={cmd.action}
                                    className="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-text-main transition-colors hover:bg-surface-100 hover:text-primary dark:text-text-darkMain dark:hover:bg-dark-surface2 dark:hover:text-primary-light"
                                >
                                    <span className="text-text-muted dark:text-text-darkMuted">
                                        {cmd.icon}
                                    </span>
                                    {cmd.label}
                                </button>
                            ))}
                        </div>
                    </motion.div>
                </>
            )}
        </AnimatePresence>
    );
}
