import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Sun, Moon, Shield, Clock, BarChart3, ChevronRight, 
    MessageSquare, AlertCircle, CheckCircle2, Menu, X, ArrowUpRight
} from 'lucide-react';

const LandingPage = () => {
    const [isDarkMode, setIsDarkMode] = useState(true);
    const [isMenuOpen, setIsMenuOpen] = useState(false);

    useEffect(() => {
        if (isDarkMode) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }, [isDarkMode]);

    const toggleTheme = () => setIsDarkMode(!isDarkMode);

    const containerVariants = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: {
                staggerChildren: 0.1
            }
        }
    };

    const itemVariants = {
        hidden: { y: 20, opacity: 0 },
        visible: {
            y: 0,
            opacity: 1,
            transition: { duration: 0.6, ease: "easeOut" }
        }
    };

    return (
        <div className={`min-h-screen font-sans transition-colors duration-500 ${isDarkMode ? 'bg-[#0a0a0a] text-white' : 'bg-white text-[#0a0a0a]'}`}>
            {/* Navigation */}
            <nav className="fixed top-0 w-full z-50 backdrop-blur-md border-b border-white/5 bg-transparent">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between h-20 items-center">
                        <div className="flex items-center gap-3">
                            <motion.div 
                                whileHover={{ rotate: 10 }}
                                className="w-10 h-10 rounded-xl bg-gradient-to-br from-[#ff6b00] to-[#ff9e00] flex items-center justify-center shadow-lg shadow-orange-500/20"
                            >
                                <Shield className="text-black w-6 h-6" />
                            </motion.div>
                            <span className="text-2xl font-bold tracking-tight">Resolve<span className="text-[#ff6b00]">X</span></span>
                        </div>

                        <div className="hidden md:flex items-center gap-8">
                            <a href="#features" className="text-sm font-medium hover:text-[#ff6b00] transition-colors">Features</a>
                            <a href="#workflow" className="text-sm font-medium hover:text-[#ff6b00] transition-colors">Workflow</a>
                            <button 
                                onClick={toggleTheme}
                                className="p-2 rounded-full hover:bg-white/5 transition-colors"
                            >
                                {isDarkMode ? <Sun className="w-5 h-5 text-[#ff6b00]" /> : <Moon className="w-5 h-5 text-[#ff6b00]" />}
                            </button>
                            <div className="flex items-center gap-3">
                                <a href="/login" className="px-5 py-2.5 text-sm font-bold rounded-xl border border-white/10 hover:bg-white/5 transition-all">Sign in</a>
                                <a href="/register" className="px-5 py-2.5 text-sm font-bold rounded-xl bg-[#ff6b00] text-black hover:bg-[#ff8533] transition-all shadow-lg shadow-orange-500/20">Get started</a>
                            </div>
                        </div>

                        <div className="md:hidden flex items-center gap-4">
                            <button onClick={toggleTheme} className="p-2">
                                {isDarkMode ? <Sun className="w-5 h-5 text-[#ff6b00]" /> : <Moon className="w-5 h-5 text-[#ff6b00]" />}
                            </button>
                            <button onClick={() => setIsMenuOpen(!isMenuOpen)} className="p-2">
                                {isMenuOpen ? <X /> : <Menu />}
                            </button>
                        </div>
                    </div>
                </div>
            </nav>

            {/* Mobile Menu */}
            <AnimatePresence>
                {isMenuOpen && (
                    <motion.div 
                        initial={{ opacity: 0, height: 0 }}
                        animate={{ opacity: 1, height: 'auto' }}
                        exit={{ opacity: 0, height: 0 }}
                        className="fixed top-20 w-full bg-[#0a0a0a] border-b border-white/5 z-40 md:hidden"
                    >
                        <div className="px-4 py-6 space-y-4">
                            <a href="#features" className="block text-lg font-medium">Features</a>
                            <a href="#workflow" className="block text-lg font-medium">Workflow</a>
                            <div className="pt-4 flex flex-col gap-3">
                                <a href="/login" className="w-full py-3 text-center rounded-xl border border-white/10">Sign in</a>
                                <a href="/register" className="w-full py-3 text-center rounded-xl bg-[#ff6b00] text-black font-bold">Get started</a>
                            </div>
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>

            {/* Hero Section */}
            <main className="pt-32 pb-20 px-4">
                <div className="max-w-7xl mx-auto">
                    <motion.div 
                        variants={containerVariants}
                        initial="hidden"
                        animate="visible"
                        className="grid lg:grid-cols-2 gap-16 items-center"
                    >
                        <div className="space-y-8">
                            <motion.div variants={itemVariants} className="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#ff6b00]/10 border border-[#ff6b00]/20 text-[#ff6b00] text-xs font-bold tracking-widest uppercase">
                                <span className="w-2 h-2 rounded-full bg-[#ff6b00] animate-pulse" />
                                SLA-Aware Startup Support
                            </motion.div>
                            
                            <motion.h1 variants={itemVariants} className="text-5xl lg:text-7xl font-bold leading-[1.1] tracking-tight">
                                Move from silent frustration to <span className="text-[#ff6b00]">visible resolution.</span>
                            </motion.h1>
                            
                            <motion.p variants={itemVariants} className={`text-lg lg:text-xl leading-relaxed ${isDarkMode ? 'text-white/60' : 'text-black/60'} max-w-xl`}>
                                ResolveX helps founders, employees, and admins manage startup grievances with ticket tracking, escalation, and AI-driven analytics.
                            </motion.p>

                            <motion.div variants={itemVariants} className="flex flex-wrap gap-4">
                                <a href="/register" className="px-8 py-4 rounded-2xl bg-[#ff6b00] text-black font-extrabold text-lg hover:scale-105 transition-transform shadow-2xl shadow-orange-500/30 flex items-center gap-2">
                                    Launch Workspace <ArrowUpRight className="w-5 h-5" />
                                </a>
                                <a href="/login" className="px-8 py-4 rounded-2xl border border-white/10 font-bold text-lg hover:bg-white/5 transition-colors">
                                    Open Demo
                                </a>
                            </motion.div>

                            <motion.div variants={itemVariants} className="grid grid-cols-3 gap-6 pt-8 border-t border-white/5">
                                <div>
                                    <h3 className="text-2xl font-bold">4-Stage</h3>
                                    <p className="text-xs text-white/40 uppercase tracking-widest font-bold mt-1">Workflow</p>
                                </div>
                                <div>
                                    <h3 className="text-2xl font-bold">SLA+AI</h3>
                                    <p className="text-xs text-white/40 uppercase tracking-widest font-bold mt-1">Smart Priority</p>
                                </div>
                                <div>
                                    <h3 className="text-2xl font-bold">360°</h3>
                                    <p className="text-xs text-white/40 uppercase tracking-widest font-bold mt-1">Analytics</p>
                                </div>
                            </motion.div>
                        </div>

                        <motion.div 
                            variants={itemVariants}
                            className="relative group"
                        >
                            <div className="absolute -inset-1 bg-gradient-to-r from-[#ff6b00] to-[#ff9e00] rounded-3xl blur opacity-20 group-hover:opacity-40 transition duration-1000 group-hover:duration-200" />
                            <div className={`relative rounded-3xl border border-white/10 p-8 ${isDarkMode ? 'bg-[#141414]' : 'bg-gray-50'}`}>
                                <div className="flex justify-between items-center mb-8">
                                    <div className="space-y-1">
                                        <p className="text-[10px] font-bold text-[#ff6b00] uppercase tracking-[0.2em]">Live Ticket Preview</p>
                                        <h4 className="text-xl font-bold">Command Center</h4>
                                    </div>
                                    <div className="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center">
                                        <div className="w-2 h-2 rounded-full bg-[#ff6b00]" />
                                    </div>
                                </div>

                                <div className={`p-6 rounded-2xl border border-white/5 ${isDarkMode ? 'bg-[#0a0a0a]' : 'bg-white shadow-xl'}`}>
                                    <div className="flex justify-between items-start mb-4">
                                        <span className="text-xs font-mono text-white/40">RX-2026-AI82K</span>
                                        <span className="px-2 py-1 rounded bg-red-500/10 text-red-500 text-[10px] font-bold uppercase">High Priority</span>
                                    </div>
                                    <h5 className="font-bold mb-2">Payroll delay complaint with anonymous mode</h5>
                                    <p className="text-sm text-white/50 leading-relaxed mb-6">Classifier recommends HR review. SLA deadline: 24h. Escalation triggered if no progress.</p>
                                    
                                    <div className="space-y-3">
                                        {[
                                            { label: 'Status', value: 'Under Review', color: 'text-orange-400' },
                                            { label: 'Sentiment', value: 'Critical', color: 'text-red-400' },
                                            { label: 'Assigned', value: 'Moderator queue', color: 'text-white' }
                                        ].map((stat, i) => (
                                            <div key={i} className="flex justify-between items-center py-2 border-t border-white/5">
                                                <span className="text-xs text-white/40">{stat.label}</span>
                                                <span className={`text-xs font-bold ${stat.color}`}>{stat.value}</span>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            </div>
                        </motion.div>
                    </motion.div>
                </div>
            </main>

            {/* Features Section */}
            <section id="features" className={`py-24 px-4 ${isDarkMode ? 'bg-[#0f0f0f]' : 'bg-gray-50'}`}>
                <div className="max-w-7xl mx-auto">
                    <div className="text-center max-w-3xl mx-auto mb-16 space-y-4">
                        <h2 className="text-4xl font-bold">Built for serious startup operations</h2>
                        <p className="text-white/50 text-lg">Beyond a basic form. Structured intake, coordinated action, and visible timelines.</p>
                    </div>

                    <div className="grid md:grid-cols-3 gap-8">
                        {[
                            { 
                                icon: <Shield className="w-8 h-8" />, 
                                title: "Role-based workspaces", 
                                desc: "Founders, employees, and admins get focused experiences they actually need."
                            },
                            { 
                                icon: <Clock className="w-8 h-8" />, 
                                title: "Tracking that feels accountable", 
                                desc: "Every complaint becomes a ticket with status progression and ownership."
                            },
                            { 
                                icon: <BarChart3 className="w-8 h-8" />, 
                                title: "Escalation & Analytics", 
                                desc: "Surface cases faster with SLA watch, smart cues, and category trends."
                            }
                        ].map((feature, i) => (
                            <motion.div 
                                key={i}
                                whileHover={{ y: -10 }}
                                className={`p-8 rounded-3xl border border-white/5 ${isDarkMode ? 'bg-[#141414]' : 'bg-white shadow-lg'}`}
                            >
                                <div className="w-14 h-14 rounded-2xl bg-[#ff6b00]/10 flex items-center justify-center text-[#ff6b00] mb-6">
                                    {feature.icon}
                                </div>
                                <h3 className="text-xl font-bold mb-3">{feature.title}</h3>
                                <p className="text-white/50 text-sm leading-relaxed">{feature.desc}</p>
                            </motion.div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Workflow Section */}
            <section id="workflow" className="py-24 px-4">
                <div className="max-w-7xl mx-auto">
                    <div className="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                        <div className="space-y-4">
                            <h2 className="text-4xl font-bold">Complaint to Closure</h2>
                            <p className="text-white/50">A simple, transparent path for every user.</p>
                        </div>
                        <a href="/register" className="text-[#ff6b00] font-bold flex items-center gap-2 group">
                            Start building your workflow <ChevronRight className="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </a>
                    </div>

                    <div className="grid md:grid-cols-5 gap-4">
                        {[
                            { step: "01", title: "User submits", desc: "Category, priority, and anonymous mode." },
                            { step: "02", title: "AI Enrich", desc: "Auto-ID, urgency cues, and SLA targets." },
                            { step: "03", title: "Admin Acts", desc: "Assignment, comments, and pipeline updates." },
                            { step: "04", title: "User Tracks", desc: "Visible timeline and live notifications." },
                            { step: "05", title: "Resolution", desc: "Feedback collection and analytics." }
                        ].map((step, i) => (
                            <div key={i} className={`p-6 rounded-2xl border border-white/5 ${isDarkMode ? 'bg-[#141414]' : 'bg-gray-50'}`}>
                                <span className="text-[10px] font-black text-[#ff6b00] tracking-widest">{step.step}</span>
                                <h4 className="font-bold mt-4 mb-2">{step.title}</h4>
                                <p className="text-xs text-white/40 leading-relaxed">{step.desc}</p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>

            {/* Footer */}
            <footer className="py-12 border-t border-white/5">
                <div className="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div className="flex items-center gap-3">
                        <div className="w-8 h-8 rounded-lg bg-[#ff6b00] flex items-center justify-center">
                            <Shield className="text-black w-5 h-5" />
                        </div>
                        <span className="font-bold">ResolveX</span>
                    </div>
                    <p className="text-sm text-white/40">© 2026 ResolveX platform for startups. Built with React & Tailwind.</p>
                    <div className="flex gap-6">
                        <a href="#" className="text-white/40 hover:text-[#ff6b00] transition-colors">Twitter</a>
                        <a href="#" className="text-white/40 hover:text-[#ff6b00] transition-colors">GitHub</a>
                    </div>
                </div>
            </footer>
        </div>
    );
};

export default LandingPage;
