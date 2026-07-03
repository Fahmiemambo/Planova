import React from 'react';
import { CheckSquare, Calendar, ChevronDown, MoreHorizontal, Plus } from 'lucide-react';

export default function TableView() {
    // A beautiful Notion-like table
    return (
        <div className="flex h-full w-full flex-col bg-white dark:bg-dark-surface">
            {/* Toolbar */}
            <div className="flex items-center gap-4 border-b border-surface-200 px-4 py-2 dark:border-dark-border">
                <button className="flex items-center gap-1.5 text-sm font-medium text-text-muted hover:text-text-main dark:text-text-darkMuted dark:hover:text-text-darkMain">
                    <span>Filter</span>
                    <ChevronDown size={14} />
                </button>
                <button className="flex items-center gap-1.5 text-sm font-medium text-text-muted hover:text-text-main dark:text-text-darkMuted dark:hover:text-text-darkMain">
                    <span>Sort</span>
                    <ChevronDown size={14} />
                </button>
            </div>

            {/* Table Area */}
            <div className="flex-1 overflow-auto">
                <table className="w-full text-left text-sm">
                    <thead className="sticky top-0 z-10 bg-surface-100 text-text-muted shadow-sm dark:bg-dark-surface2 dark:text-text-darkMuted">
                        <tr>
                            <th className="w-10 px-4 py-3 font-medium">
                                <input type="checkbox" className="rounded border-surface-300" />
                            </th>
                            <th className="group relative w-1/3 px-4 py-3 font-medium hover:bg-surface-200 dark:hover:bg-dark-border/50">
                                <div className="flex items-center gap-2">
                                    <CheckSquare size={14} /> Task Name
                                </div>
                            </th>
                            <th className="group relative px-4 py-3 font-medium hover:bg-surface-200 dark:hover:bg-dark-border/50">
                                Status
                            </th>
                            <th className="group relative px-4 py-3 font-medium hover:bg-surface-200 dark:hover:bg-dark-border/50">
                                Priority
                            </th>
                            <th className="group relative px-4 py-3 font-medium hover:bg-surface-200 dark:hover:bg-dark-border/50">
                                <div className="flex items-center gap-2">
                                    <Calendar size={14} /> Date
                                </div>
                            </th>
                            <th className="w-10 px-4 py-3 font-medium">
                                <Plus size={16} className="cursor-pointer text-text-muted hover:text-text-main" />
                            </th>
                        </tr>
                    </thead>
                    <tbody className="divide-y divide-surface-100 dark:divide-dark-border/50">
                        {/* Mock Row 1 */}
                        <tr className="group transition-colors hover:bg-surface-50 dark:hover:bg-dark-surface2/30">
                            <td className="px-4 py-2.5">
                                <input type="checkbox" className="rounded border-surface-300 opacity-0 transition-opacity group-hover:opacity-100" />
                            </td>
                            <td className="px-4 py-2.5 font-medium">
                                <input type="text" defaultValue="Research competitors" className="w-full bg-transparent outline-none" />
                            </td>
                            <td className="px-4 py-2.5">
                                <span className="inline-flex cursor-pointer items-center rounded bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-700 dark:bg-gray-800 dark:text-gray-300">
                                    Not Started
                                </span>
                            </td>
                            <td className="px-4 py-2.5">
                                <span className="inline-flex cursor-pointer items-center rounded px-2 py-0.5 text-xs font-medium text-orange-600 dark:text-orange-400">
                                    High
                                </span>
                            </td>
                            <td className="px-4 py-2.5 text-text-muted dark:text-text-darkMuted">
                                Aug 24
                            </td>
                            <td className="px-4 py-2.5">
                                <button className="opacity-0 transition-opacity group-hover:opacity-100">
                                    <MoreHorizontal size={16} className="text-text-muted" />
                                </button>
                            </td>
                        </tr>
                        {/* New Row Input */}
                        <tr className="hover:bg-surface-50 dark:hover:bg-dark-surface2/30">
                            <td className="px-4 py-2.5 text-center">
                                <Plus size={14} className="inline-block text-text-muted" />
                            </td>
                            <td colSpan="5" className="px-4 py-2.5 text-text-muted">
                                <input type="text" placeholder="New task..." className="w-full bg-transparent text-sm outline-none placeholder:text-text-muted/50" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    );
}
