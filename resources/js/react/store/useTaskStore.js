import { create } from 'zustand';

const useTaskStore = create((set) => ({
    currentView: 'table', // table, board, calendar, timeline, gallery, list
    searchQuery: '',
    selectedTask: null,
    
    setView: (view) => set({ currentView: view }),
    setSearchQuery: (query) => set({ searchQuery: query }),
    setSelectedTask: (task) => set({ selectedTask: task }),
}));

export default useTaskStore;
